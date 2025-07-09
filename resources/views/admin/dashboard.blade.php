<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Events</div>
                        <div class="text-3xl font-bold">{{ $statistics['total_events'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Users</div>
                        <div class="text-3xl font-bold">{{ $statistics['total_users'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Registrations</div>
                        <div class="text-3xl font-bold">{{ $statistics['total_registrations'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm">Total Revenue</div>
                        <div class="text-3xl font-bold">Rp {{ number_format($statistics['revenue'], 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Latest Events</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left">Title</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Registrations</th>
                                        <th class="px-4 py-2 text-left">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestEvents as $event)
                                        <tr>
                                            <td class="border-t px-4 py-2">{{ $event->title }}</td>
                                            <td class="border-t px-4 py-2">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</td>
                                            <td class="border-t px-4 py-2">{{ $event->registered_count }}</td>
                                            <td class="border-t px-4 py-2">
                                                <a href="{{ route('events.show', $event) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border-t px-4 py-2" colspan="4">No events found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 text-right">
                            <a href="{{ route('events.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create New Event
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Latest Registrations</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left">User</th>
                                        <th class="px-4 py-2 text-left">Event</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestRegistrations as $registration)
                                        <tr>
                                            <td class="border-t px-4 py-2">{{ $registration->user->name }}</td>
                                            <td class="border-t px-4 py-2">{{ $registration->event->title }}</td>
                                            <td class="border-t px-4 py-2">{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</td>
                                            <td class="border-t px-4 py-2">
                                                @if($registration->status === 'confirmed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Confirmed
                                                    </span>
                                                @elseif($registration->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Canceled
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border-t px-4 py-2" colspan="4">No registrations found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>