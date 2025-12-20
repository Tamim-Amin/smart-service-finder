<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Service') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Provider Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Provider Information</h3>
                    <div class="flex items-start space-x-4">
                        <img src="{{ $provider->user->profile_photo_url }}" alt="{{ $provider->user->name }}"
                            class="w-20 h-20 rounded-full object-cover border-2 border-indigo-200">
                        <div class="flex-1">
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $provider->user->name }}</p>
                            <p class="text-indigo-600 font-semibold mb-2">{{ $provider->category->name }}</p>
                            <p class="text-gray-600 mb-3">{{ $provider->bio }}</p>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $provider->location }}
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $provider->experience_years }} years experience
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400 fill-current mr-2" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                    <span class="font-semibold">{{ number_format($provider->average_rating, 1) }}</span>
                                    <span class="text-gray-500 ml-1">({{ $provider->total_reviews }} reviews)</span>
                                </div>
                                <div class="text-2xl font-bold text-green-600">
                                    ৳{{ number_format($provider->hourly_rate, 0) }}/hour
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Booking Details</h3>

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST" id="booking-form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                        <input type="hidden" id="hourly_rate" value="{{ $provider->hourly_rate }}">

                        <!-- Problem Description -->
                        <div>
                            <label for="problem_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Describe Your Problem *
                            </label>
                            <textarea name="problem_description" id="problem_description" rows="4" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Please describe what service you need...">{{ old('problem_description') }}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Service Date -->
                            <div>
                                <label for="service_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Date *
                                </label>
                                <input type="date" name="service_date" id="service_date" required
                                    min="{{ date('Y-m-d') }}" value="{{ old('service_date') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Service Time -->
                            <div>
                                <label for="service_time" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Time *
                                </label>
                                <input type="time" name="service_time" id="service_time" required
                                    value="{{ old('service_time') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Estimated Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Estimated Service Duration *
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label
                                    class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                    <input type="radio" name="estimated_duration" value="0.5" class="sr-only peer"
                                        required onchange="calculateCost()">
                                    <span
                                        class="text-2xl font-bold text-gray-700 peer-checked:text-indigo-600">30</span>
                                    <span class="text-xs text-gray-500">Minutes</span>
                                    <div
                                        class="absolute inset-0 border-2 border-indigo-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                    </div>
                                </label>

                                <label
                                    class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                    <input type="radio" name="estimated_duration" value="1" class="sr-only peer"
                                        required checked onchange="calculateCost()">
                                    <span class="text-2xl font-bold text-gray-700 peer-checked:text-indigo-600">1</span>
                                    <span class="text-xs text-gray-500">Hour</span>
                                    <div
                                        class="absolute inset-0 border-2 border-indigo-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                    </div>
                                </label>

                                <label
                                    class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                    <input type="radio" name="estimated_duration" value="2" class="sr-only peer"
                                        required onchange="calculateCost()">
                                    <span class="text-2xl font-bold text-gray-700 peer-checked:text-indigo-600">2</span>
                                    <span class="text-xs text-gray-500">Hours</span>
                                    <div
                                        class="absolute inset-0 border-2 border-indigo-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                    </div>
                                </label>

                                <label
                                    class="relative flex flex-col items-center justify-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                                    <input type="radio" name="estimated_duration" value="3" class="sr-only peer"
                                        required onchange="calculateCost()">
                                    <span class="text-2xl font-bold text-gray-700 peer-checked:text-indigo-600">3</span>
                                    <span class="text-xs text-gray-500">Hours</span>
                                    <div
                                        class="absolute inset-0 border-2 border-indigo-600 rounded-lg opacity-0 peer-checked:opacity-100">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Cost Summary -->
                        <div
                            class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border-2 border-indigo-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Cost Summary</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Hourly Rate:</span>
                                    <span
                                        class="font-semibold">৳{{ number_format($provider->hourly_rate, 0) }}/hour</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Duration:</span>
                                    <span class="font-semibold" id="duration-display">1 hour</span>
                                </div>
                                <div class="border-t-2 border-indigo-200 pt-3 flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-800">Estimated Total:</span>
                                    <span class="text-2xl font-bold text-indigo-600"
                                        id="total-cost">৳{{ number_format($provider->hourly_rate, 0) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    💡 Final amount may vary based on actual service duration
                                </p>
                            </div>
                        </div>

                        <!-- Info Note -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                <strong>Note:</strong> The provider will review your booking request and can accept or
                                reject it.
                                You will be notified once the provider responds. The estimated cost is calculated based
                                on your selected duration.
                            </p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('customer.search') }}"
                                class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit" id="submitBtn"
                                class="bg-indigo-600 text-white px-8 py-3 rounded-md hover:bg-indigo-700 transition font-semibold flex items-center disabled:opacity-75 disabled:cursor-not-allowed">
                                <span id="btnText">Send Booking Request</span>
                                <svg id="loadingSpinner" class="hidden animate-spin h-5 w-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Form submission handler with loading indicator
        document.getElementById('booking-form').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const spinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');
            
            submitBtn.disabled = true;
            spinner.classList.remove('hidden');
            btnText.textContent = 'Sending request...';
        });

        // Calculate estimated cost
        function calculateCost() {
            const hourlyRate = parseFloat(document.getElementById('hourly_rate').value);
            const durationRadios = document.getElementsByName('estimated_duration');
            let duration = 1;

            for (const radio of durationRadios) {
                if (radio.checked) {
                    duration = parseFloat(radio.value);
                    break;
                }
            }

            const totalCost = duration * hourlyRate;

            // Update display
            document.getElementById('total-cost').textContent = '৳' + totalCost.toLocaleString();

            // Update duration display
            if (duration === 0.5) {
                document.getElementById('duration-display').textContent = '30 minutes';
            } else if (duration === 1) {
                document.getElementById('duration-display').textContent = '1 hour';
            } else {
                document.getElementById('duration-display').textContent = duration + ' hours';
            }
        }

        // Show/hide transaction ID field based on payment method
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const transactionField = document.getElementById('transaction-field');
                const transactionInput = document.getElementById('transaction_id');

                if (this.value === 'bkash' || this.value === 'nagad') {
                    transactionField.classList.remove('hidden');
                    transactionInput.required = true;
                } else {
                    transactionField.classList.add('hidden');
                    transactionInput.required = false;
                    transactionInput.value = '';
                }
            });
        });

        // Calculate cost on page load
        window.addEventListener('load', calculateCost);
    </script>
</x-app-layout>