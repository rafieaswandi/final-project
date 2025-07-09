<?php

// app/Http/Controllers/RegistrationController.php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function register(Event $event)
    {
        // Cek apakah user sudah terdaftar pada event ini
        $existingRegistration = Registration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->first();
            
        if ($existingRegistration) {
            return redirect()->back()
                ->with('error', 'Anda sudah terdaftar pada event ini');
        }
        
        // Cek kapasitas event
        if ($event->capacity && $event->remaining_capacity <= 0) {
            return redirect()->back()
                ->with('error', 'Maaf, event ini sudah penuh');
        }
        
        // Buat pendaftaran baru
        $registration = Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'registration_date' => now(),
            'status' => $event->price > 0 ? 'pending' : 'confirmed'
        ]);
        
        // Jika event berbayar, redirect ke halaman pembayaran
        if ($event->price > 0) {
            return redirect()->route('payments.create', $registration);
        }
        
        return redirect()->route('registrations.index')
            ->with('success', 'Pendaftaran berhasil');
    }
    
    public function index()
    {
        $registrations = Registration::where('user_id', Auth::id())
            ->with('event')
            ->get();
            
        return view('registrations.index', compact('registrations'));
    }
    
    public function show(Registration $registration)
    {
        // Pastikan user hanya bisa melihat registrasinya sendiri
        if ($registration->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('registrations.show', compact('registration'));
    }
    
    public function cancel(Registration $registration)
    {
        // Pastikan user hanya bisa membatalkan registrasinya sendiri
        if ($registration->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        // Cek apakah registrasi masih bisa dibatalkan
        if ($registration->status === 'confirmed' && $registration->event->date < now()) {
            return redirect()->back()
                ->with('error', 'Event sudah berlalu, tidak bisa dibatalkan');
        }
        
        $registration->update(['status' => 'canceled']);
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Pendaftaran berhasil dibatalkan');
    }
}