<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Booking History</h3>

                    @forelse($bookings as $booking)
                    <div class="border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <img src="{{ $booking->provider->user->profile_photo_url }}"
                                        alt="{{ $booking->provider->user->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mr-3">
                                    <div>
                                        <h4 class="text-lg font-semibold">{{ $booking->provider->user->name }}</h4>
                                        <span
                                            class="text-sm text-gray-600">{{ $booking->provider->category->name }}</span>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-600 space-y-1">
                                    <p><strong>Date:</strong> {{ $booking->service_date->format('M d, Y') }}</p>
                                    <p><strong>Time:</strong> {{ date('g:i A', strtotime($booking->service_time)) }}</p>
                                    <p><strong>Duration:</strong> {{ $booking->estimated_duration }} hour(s)</p>
                                    <p><strong>Estimated Cost:</strong>
                                        ৳{{ number_format($booking->estimated_cost, 0) }}</p>
                                    <p><strong>Payment Method:</strong>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                                                                            {{ $booking->payment_method === 'cash' ? 'bg-green-100 text-green-800' :
                        ($booking->payment_method === 'bkash' ? 'bg-pink-100 text-pink-800' : 'bg-orange-100 text-orange-800') }}">
                                            {{ ucfirst($booking->payment_method) }}
                                        </span>
                                    </p>
                                    @if($booking->transaction_id)
                                    <p><strong>Transaction ID:</strong> {{ $booking->transaction_id }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="ml-4">
                                @if($booking->status == 'pending')
                                <span
                                    class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">Pending</span>
                                @elseif($booking->status == 'accepted')
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Accepted</span>
                                @elseif($booking->status == 'completed')
                                <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Completed</span>
                                @elseif($booking->status == 'rejected')
                                <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">Rejected</span>
                                @endif
                            </div>
                        </div>

                        <!-- Chat Button - Only show for ACCEPTED bookings -->
                        @if($booking->status == 'accepted')
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <!-- Payment Section - Show if payment not completed -->
                            @if($booking->payment_status !== 'paid')
                            <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-4">
                                <p class="text-sm font-semibold text-blue-900 mb-3">Payment Required</p>
                                <p class="text-sm text-blue-800 mb-3">Amount:
                                    <strong>৳{{ number_format($booking->estimated_cost, 0) }}</strong>
                                </p>

                                <form action="{{ route('bookings.payment', $booking->id) }}" method="POST"
                                    class="space-y-3">
                                    @csrf

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-3">Payment
                                            Method</label>
                                        <div class="grid grid-cols-3 gap-3">
                                            <!-- Cash -->
                                            <label
                                                class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-500 transition group">
                                                <input type="radio" name="payment_method" value="cash"
                                                    class="sr-only peer" required
                                                    onchange="updateTransactionField(this)">
                                                <svg class="w-10 h-10 text-gray-400 group-hover:text-green-500 peer-checked:text-green-600 mb-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                <span
                                                    class="text-xs font-semibold text-gray-700 peer-checked:text-green-600">Cash</span>
                                                <div
                                                    class="absolute inset-0 border-2 border-green-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                                </div>
                                            </label>

                                            <!-- Bkash -->
                                            <label
                                                class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-pink-500 transition group">
                                                <input type="radio" name="payment_method" value="bkash"
                                                    class="sr-only peer" required
                                                    onchange="updateTransactionField(this)">
                                                <div
                                                    class="w-10 h-10 bg-pink-600 rounded-lg flex items-center justify-center mb-2 group-hover:bg-pink-700 peer-checked:bg-pink-700">
                                                    <span class="text-white font-bold text-xs">৳</span>
                                                </div>
                                                <span
                                                    class="text-xs font-semibold text-gray-700 peer-checked:text-pink-600">bKash</span>
                                                <div
                                                    class="absolute inset-0 border-2 border-pink-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                                </div>
                                            </label>

                                            <!-- Nagad -->
                                            <label
                                                class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-orange-500 transition group">
                                                <input type="radio" name="payment_method" value="nagad"
                                                    class="sr-only peer" required
                                                    onchange="updateTransactionField(this)">
                                                <div
                                                    class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center mb-2 group-hover:bg-orange-700 peer-checked:bg-orange-700">
                                                    <span class="text-white font-bold text-xs">N</span>
                                                </div>
                                                <span
                                                    class="text-xs font-semibold text-gray-700 peer-checked:text-orange-600">Nagad</span>
                                                <div
                                                    class="absolute inset-0 border-2 border-orange-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                                </div>
                                            </label>
                                        </div>
                                        @error('payment_method')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div id="transaction-id-field" style="display:none;">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Transaction
                                            ID</label>
                                        <input type="text" name="transaction_id" placeholder="Enter transaction ID"
                                            class="w-full border border-gray-300 rounded-md py-2 px-3 text-sm">
                                        @error('transaction_id')
                                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium transition">
                                        Confirm Payment
                                    </button>
                                </form>

                                <script>
                                function updateTransactionField(input) {
                                    const field = document.getElementById('transaction-id-field');
                                    if (input.value === 'bkash' || input.value === 'nagad') {
                                        field.style.display = 'block';
                                        field.querySelector('input').required = true;
                                    } else {
                                        field.style.display = 'none';
                                        field.querySelector('input').required = false;
                                    }
                                }
                                </script>
                            </div>
                            @else
                            <div class="bg-green-50 border border-green-200 rounded p-4 mb-4">
                                <p class="text-sm text-green-800"><strong>✓ Payment Confirmed</strong></p>
                                <p class="text-xs text-green-600">Amount:
                                    ৳{{ number_format($booking->estimated_cost, 0) }} via
                                    {{ ucfirst($booking->payment_method) }}
                                </p>
                            </div>
                            @endif

                            <a href="{{ route('chat.show', $booking->id) }}"
                                class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Chat with {{ $booking->provider->user->name }}
                                @if($booking->unreadMessagesFor(Auth::id()) > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                                    {{ $booking->unreadMessagesFor(Auth::id()) }}
                                </span>
                                @endif
                            </a>
                        </div>
                        @endif

                        <!-- Review Section - Only for completed bookings -->
                        @if($booking->status == 'completed' && !$booking->review)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('reviews.create', $booking->id) }}"
                                class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                                Write a Review
                            </a>
                        </div>
                        @endif

                        @if($booking->review)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm font-semibold mb-1">Your Review:</p>
                            <div class="flex items-center mb-2">
                                @for($i = 1; $i <= 5; $i++) <svg
                                    class="w-4 h-4 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                    @endfor
                            </div>
                            <p class="text-sm text-gray-600">{{ $booking->review->comment }}</p>
                        </div>
                        @endif
                    </div>
                    @empty
                    <p class="text-gray-500 text-center py-8">No bookings yet. Start by searching for service providers!
                    </p>
                    @endforelse

                    <div class="mt-6">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>