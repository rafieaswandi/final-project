<?php

// app/Http/Controllers/EventController.php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    
    public function index()
    {
        // Implementasi caching
        $events = Cache::remember('events', 60*60, function () {
            return Event::all();
        });
        
        return view('events.index', compact('events'));
    }
    
    public function create()
    {
        return view('events.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric',
            'capacity' => 'nullable|integer|min:1'
        ]);
        
        Event::create($validated);
        
        // Clear cache ketika ada perubahan data
        Cache::forget('events');
        
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dibuat');
    }
    
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }
    
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }
    
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric',
            'capacity' => 'nullable|integer|min:1'
        ]);
        
        $event->update($validated);
        
        // Clear cache ketika ada perubahan data
        Cache::forget('events');
        
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diperbarui');
    }
    
    public function destroy(Event $event)
    {
        $event->delete();
        
        // Clear cache ketika ada perubahan data
        Cache::forget('events');
        
        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus');
    }
}