<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Events') }}
            </h2>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create New Event
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-2">{{ $event->title }}</h3>
                            <p class="text-gray-600 mb-2">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                            <div class="flex justify-between text-sm mb-4">
                                <span>{{ $event->location }}</span>
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold">{{ $event->price > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Free' }}</span>
                                <a href="{{ route('events.show', $event) }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold py-1 px-3 rounded">
                                    View Details
                                </a>
                            </div>
                            @if($event->capacity)
                                <div class="mt-3 text-sm text-gray-600">
                                    <span>Capacity: {{ $event->registered_count }}/{{ $event->capacity }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <p class="text-gray-600">No events available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>