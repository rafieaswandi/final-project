<?php

// app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $statistics = Cache::remember('admin_dashboard', 30, function () {
            return [
                'total_events' => Event::count(),
                'total_users' => User::count(),
                'total_registrations' => Registration::count(),
                'revenue' => Payment::where('status', 'settlement')->sum('amount')
            ];
        });

        $latestEvents = Event::latest()->take(5)->get();
        $latestRegistrations = Registration::with(['user', 'event'])->latest()->take(5)->get();
        // Implementasi caching
        $events = Cache::remember('events', 60 * 60, function () {
            return Event::all();
        });

        return auth()->user()->role === 'admin'
            ? view('admin.dashboard', compact('statistics', 'latestEvents', 'latestRegistrations'))
            : view('events.index', compact('events'));
    }
}
