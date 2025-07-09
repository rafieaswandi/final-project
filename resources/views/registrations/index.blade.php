<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Registrations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($registrations->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Event</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registrations as $registration)
                                        <tr>
                                            <td class="py-4 px-4 border-b border-gray-200">
                                                <div class="text-sm font-medium text-gray-900">{{ $registration->event->title }}</div>
                                                <div class="text-sm text-gray-500">{{ $registration->event->location }}</div>
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200">
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $registration->event->time }}</div>
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200">
                                                @if($registration->status === 'confirmed')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Konfirmasi
                                                    </span>
                                                @elseif($registration->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pembayaran Tertunda
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Batal
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-4 border-b border-gray-200 text-sm">
                                                <a href="{{ route('registrations.show', $registration) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                
                                                @if($registration->status === 'pending')
                                                    <a href="{{ route('payments.create', $registration) }}" class="text-green-600 hover:text-green-900 mr-3">Pay Now</a>
                                                @endif
                                                
                                                @if($registration->status !== 'canceled' && $registration->event->date > now())
                                                    <form action="{{ route('registrations.cancel', $registration) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to cancel this registration?');">Cancel</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-600">You don't have any registrations yet.</p>
                            <a href="{{ route('events.index') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Browse Events
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>