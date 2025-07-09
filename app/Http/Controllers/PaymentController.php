<?php

// app/Http/Controllers/PaymentController.php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['notification']);
        
        // Set konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');  // Langsung mengakses dari env
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
    
    public function create(Registration $registration)
    {
        // Pastikan user hanya bisa membayar registrasinya sendiri
        if ($registration->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Pastikan registrasi belum dibayar
        if ($registration->status !== 'pending') {
            return redirect()->route('registrations.show', $registration)
                ->with('error', 'Registrasi ini sudah dibayar atau dibatalkan');
        }
        
        $event = $registration->event;
        
        // Buat parameter untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'REG-' . $registration->id . '-' . time(),
                'gross_amount' => $event->price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'item_details' => [
                [
                    'id' => $event->id,
                    'price' => $event->price,
                    'quantity' => 1,
                    'name' => $event->title,
                ]
            ]
        ];
        
        // Dapatkan token transaksi dari Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);
            \Log::info('Snap Token:', ['token' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error:', ['message' => $e->getMessage()]);
            return redirect()->route('registrations.show', $registration)
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
        
        return view('payments.create', compact('registration', 'event', 'snapToken'));
    }
    
    public function store(Request $request, Registration $registration)
    {
        // Validasi input
        $validated = $request->validate([
            'transaction_id' => 'required',
            'payment_method' => 'required',
            'status' => 'required',
        ]);
        
        // Simpan data pembayaran
        Payment::create([
            'registration_id' => $registration->id,
            'amount' => $registration->event->price,
            'payment_date' => now(),
            'payment_method' => $validated['payment_method'],
            'status' => $validated['status'],
            'transaction_id' => $validated['transaction_id'],
        ]);
        
        // Update status registrasi
        if ($validated['status'] === 'settlement') {
            $registration->update(['status' => 'confirmed']);
        }
        
        return redirect()->route('registrations.show', $registration)
            ->with('success', 'Pembayaran berhasil diproses');
    }
    
    public function notification(Request $request)
    {
        $notification = new \Midtrans\Notification();
        
        // Ambil order_id
        $orderId = $notification->order_id;
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        
        // Ekstrak ID registrasi dari order_id (format: REG-{id}-{timestamp})
        preg_match('/REG-(\d+)-/', $orderId, $matches);
        $registrationId = $matches[1];
        
        $registration = Registration::findOrFail($registrationId);
        
        // Update status pembayaran
        $payment = Payment::where('registration_id', $registrationId)->first();
        
        if ($payment) {
            $payment->update([
                'status' => $status,
                'payment_method' => $type,
            ]);
            
            // Update status registrasi jika pembayaran berhasil
            if (in_array($status, ['settlement', 'capture'])) {
                $registration->update(['status' => 'confirmed']);
            } elseif ($status === 'deny' || $status === 'expire' || $status === 'cancel') {
                $registration->update(['status' => 'canceled']);
            }
        }
        
        return response()->json(['status' => 'success']);
    }
}
