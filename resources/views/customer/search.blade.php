<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Service Providers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('customer.search') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Provider name...">
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category_id" id="category_id" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Categories</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                <select name="location" id="location" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Locations</option>
                                    @foreach($locations ?? [] as $location)
                                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <!-- Provider Results -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($providers as $provider)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <!-- Provider Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $provider->user->name }}</h3>
                                    <p class="text-indigo-600 font-semibold">{{ $provider->category->name }}</p>
                                </div>
                                @if($provider->is_available)
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Available</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Busy</span>
                                @endif
                            </div>

                            <!-- Bio -->
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($provider->bio, 100) }}</p>

                            <!-- Details -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $provider->location }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $provider->experience_years }} years experience
                                </div>
                            </div>

                            <!-- Rating and Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <span class="ml-1 font-semibold">{{ number_format($provider->average_rating, 1) }}</span>
                                    <span class="ml-1 text-sm text-gray-500">({{ $provider->total_reviews }})</span>
                                </div>
                                <div class="text-green-600 font-bold">
                                    ৳{{ number_format($provider->hourly_rate, 0) }}/hr
                                </div>
                            </div>

                            <!-- Book Button -->
                            <a href="{{ route('bookings.create', $provider->id) }}" 
                                class="block w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition {{ !$provider->is_available ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ !$provider->is_available ? 'onclick="return false;"' : '' }}>
                                {{ $provider->is_available ? 'Book Now' : 'Not Available' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            No service providers found. Try adjusting your filters.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $providers->links() }}
            </div>

        </div>
    </div>
</x-app-layout>