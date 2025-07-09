<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $event->title }}
            </h2>
            @auth
                @if(auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('events.edit', $event) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit Event
                        </a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Event
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold mb-4">{{ $event->title }}</h3>
                            <div class="prose max-w-none">
                                <p>{{ $event->description }}</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Date & Time</h4>
                                <p>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }} at {{ $event->time }}</p>
                            </div>
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Location</h4>
                                <p>{{ $event->location }}</p>
                            </div>
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Price</h4>
                                <p class="text-lg font-bold">{{ $event->price > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Free' }}</p>
                            </div>
                            @if($event->capacity)
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700">Availability</h4>
                                    <p>{{ $event->remaining_capacity }} seats remaining</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        @php
                                            $percentage = $event->capacity > 0 ? ($event->registered_count / $event->capacity) * 100 : 0;
                                        @endphp
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            @auth
                                @php
                                    $existingRegistration = auth()->user()->registrations()->where('event_id', $event->id)->first();
                                @endphp
                                
                                @if($existingRegistration)
                                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                                        <p>You are registered for this event.</p>
                                        <a href="{{ route('registrations.show', $existingRegistration) }}" class="text-green-700 underline">View your registration</a>
                                    </div>
                                @else
                                    @if($event->remaining_capacity === 0 && $event->capacity)
                                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                                            <p>This event is fully booked.</p>
                                        </div>
                                    @else
                                        <form action="{{ route('registrations.register', $event) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                Register Now
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            @else
                                <div class="text-center mt-2">
                                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login to register for this event</a>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>