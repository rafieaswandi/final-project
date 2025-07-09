<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Registration Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div class="md:col-span-2">
                            <h3 class="mb-4 text-2xl font-bold">{{ $registration->event->title }}</h3>

                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Deskripsi</h4>
                                <p class="mt-1">{{ $registration->event->description }}</p>
                            </div>

                            <div class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <h4 class="font-semibold text-gray-700">Tanggal & Waktu</h4>
                                    <p class="mt-1">{{ \Carbon\Carbon::parse($registration->event->date)->format('d M Y') }} at {{ $registration->event->time }}</p>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-700">Lokasi</h4>
                                    <p class="mt-1">{{ $registration->event->location }}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Tanggal Registrasi</h4>
                                <p class="mt-1">{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="rounded-lg bg-gray-50 p-4">
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Status Registrasi</h4>
                                @if ($registration->status === 'confirmed')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">
                                        Konfirmasi
                                    </span>
                                @elseif($registration->status === 'pending')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">
                                        Pembayaran Tertunda
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">
                                        Batal
                                    </span>
                                @endif
                            </div>

                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Harga</h4>
                                <p class="text-lg font-bold">{{ $registration->event->price > 0 ? 'Rp ' . number_format($registration->event->price, 0, ',', '.') : 'Free' }}</p>
                            </div>

                            @if ($registration->payment)
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-700">Detail Pembayaran</h4>
                                    <div class="mt-2">
                                        <p><strong>Amount:</strong> Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}</p>
                                        <p><strong>Method:</strong> {{ $registration->payment->payment_method }}</p>
                                        <p><strong>Date:</strong> {{ $registration->payment->payment_date }}</p>
                                        <p><strong>Status:</strong> {{ ucfirst($registration->payment->status) }}</p>
                                        @if ($registration->payment->transaction_id)
                                            <p><strong>Transaction ID:</strong> {{ $registration->payment->transaction_id }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($registration->status === 'pending')
                                <a href="{{ route('payments.create', $registration) }}" class="block w-full rounded bg-blue-500 px-4 py-2 text-center font-bold text-white hover:bg-blue-700">
                                    Bayar Sekarang
                                </a>
                            @endif

                            @if ($registration->status !== 'canceled' && $registration->event->date > now())
                                <form action="{{ route('registrations.cancel', $registration) }}" method="POST" class="mt-4">
                                    @csrf
                                    <button type="submit" class="w-full rounded bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-700" onclick="return confirm('Apakah Anda yakin ingin membatalkan registrasi ini?');">
                                        Batal Registrasi
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
</x-app-layout>
