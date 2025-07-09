<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold mb-4">{{ $event->title }}</h3>
                            
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Registration Details</h4>
                                <p class="mt-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</p>
                                <p><strong>Time:</strong> {{ $event->time }}</p>
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Amount to Pay</h4>
                                <p class="text-lg font-bold">Rp {{ number_format($event->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 mb-4">Payment Method</h4>
                            
                            <div id="payment-button"></div>
                            
                            <form id="payment-form" action="{{ route('payments.store', $registration) }}" method="POST" class="hidden">
                                @csrf
                                <input type="hidden" name="transaction_id" id="transaction_id">
                                <input type="hidden" name="payment_method" id="payment_method">
                                <input type="hidden" name="status" id="status">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger snap popup
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    handlePaymentResponse(result, 'settlement');
                },
                onPending: function(result) {
                    handlePaymentResponse(result, 'pending');
                },
                onError: function(result) {
                    alert('Payment failed');
                    console.log(result);
                },
                onClose: function() {
                    alert('You closed the payment window without completing the payment');
                }
            });
            
            function handlePaymentResponse(result, status) {
                document.getElementById('transaction_id').value = result.transaction_id;
                document.getElementById('payment_method').value = result.payment_type;
                document.getElementById('status').value = status;
                document.getElementById('payment-form').submit();
            }
        });
    </script>
    @endpush
</x-app-layout>