<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write a Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Booking Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Service Details</h3>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Provider:</strong> {{ $booking->provider->user->name }}</p>
                        <p><strong>Category:</strong> {{ $booking->provider->category->name }}</p>
                        <p><strong>Service Date:</strong> {{ $booking->service_date->format('M d, Y') }}</p>
                        <p><strong>Problem:</strong> {{ $booking->problem_description }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Share Your Experience</h3>

                    <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Rating *</label>
                            <div class="flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" required class="hidden rating-input">
                                        <svg class="w-10 h-10 star-icon text-gray-300 hover:text-yellow-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Review (Optional)
                            </label>
                            <textarea name="comment" id="comment" rows="4"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Tell others about your experience with this provider...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('customer.bookings') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Star rating interaction
        document.querySelectorAll('.rating-input').forEach((input, index) => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.star-icon').forEach((star, i) => {
                    if (i <= index) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            });
        });
    </script>
</x-app-layout>