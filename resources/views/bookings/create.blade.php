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
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-2xl font-bold text-gray-900 mb-1">{{ $provider->user->name }}</p>
                            <p class="text-indigo-600 font-semibold mb-3">{{ $provider->category->name }}</p>
                            <p class="text-gray-600 mb-4">{{ $provider->bio }}</p>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                {{ $provider->location }}
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $provider->experience_years }} years experience
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-400 fill-current mr-2" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
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

            <!-- Booking Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Booking Details</h3>

                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">

                        <!-- Problem Description -->
                        <div>
                            <label for="problem_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Describe Your Problem *
                            </label>
                            <textarea name="problem_description" id="problem_description" rows="4" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Please describe what service you need...">{{ old('problem_description') }}</textarea>
                            @error('problem_description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Date -->
                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Preferred Date *
                            </label>
                            <input type="date" name="service_date" id="service_date" required
                                min="{{ date('Y-m-d') }}"
                                value="{{ old('service_date') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('service_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Time -->
                        <div>
                            <label for="service_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Preferred Time *
                            </label>
                            <input type="time" name="service_time" id="service_time" required
                                value="{{ old('service_time') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('service_time')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Note -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                <strong>Note:</strong> The provider will review your booking request and can accept or reject it. 
                                You will be notified once the provider responds.
                            </p>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('customer.search') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-300 transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                                Send Booking Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>