<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Browse Service Providers') }}
            </h2>
            <a href="{{ route('customer.dashboard') }}"
                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search Header -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Find Your Service Provider</h3>
                <p class="text-gray-600">Explore verified and trusted professionals in your area</p>
            </div>

            <!-- Search Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <form action="{{ route('customer.search') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search by Name
                            </label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Provider name...">
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                Category
                            </label>
                            <select name="category_id" id="category_id"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                Location
                            </label>
                            <select name="location" id="location"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Locations</option>
                                @foreach($locations ?? [] as $location)
                                    <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Count -->
            @if($providers->total() > 0)
                <p class="text-gray-600 mb-6">Found <span
                        class="font-semibold text-gray-900">{{ $providers->total() }}</span> service provider(s)</p>
            @endif

            <!-- Provider Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($providers as $provider)
                    <div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition overflow-hidden">
                        <!-- Provider Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-20"></div>

                        <!-- Provider Info -->
                        <div class="p-6 pt-0">
                            <div class="flex items-start -mt-10 mb-4">
                                <img src="{{ $provider->user->profile_photo_url }}" alt="{{ $provider->user->name }}"
                                    class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-md">
                                <div class="ml-4 flex-1">
                                    @if($provider->is_available)
                                        <span
                                            class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-semibold">✓
                                            Available</span>
                                    @else
                                        <span
                                            class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-semibold">Busy</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Name and Category -->
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $provider->user->name }}</h3>
                            <p class="text-indigo-600 font-semibold text-sm mb-3">{{ $provider->category->name }}</p>

                            <!-- Bio -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $provider->bio }}</p>

                            <!-- Details -->
                            <div class="space-y-2 mb-4 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    </svg>
                                    {{ $provider->location }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $provider->experience_years }}
                                    {{ $provider->experience_years > 1 ? 'years' : 'year' }} experience
                                </div>
                            </div>

                            <!-- Rating and Price -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= round($provider->average_rating) ? 'text-yellow-400' : 'text-gray-300' }} fill-current"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span
                                        class="ml-2 text-sm text-gray-600">{{ number_format($provider->average_rating, 1) }}
                                        <span class="text-xs">({{ $provider->total_reviews }} reviews)</span></span>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-green-600">
                                        ৳{{ number_format($provider->hourly_rate, 0) }}</p>
                                    <p class="text-xs text-gray-500">per hour</p>
                                </div>
                            </div>

                            <!-- Book Button -->
                            <a href="{{ route('bookings.create', $provider->id) }}"
                                class="block w-full text-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-medium {{ !$provider->is_available ? 'opacity-50 cursor-not-allowed bg-gray-400' : '' }}"
                                {{ !$provider->is_available ? 'onclick="event.preventDefault(); alert(\'Provider is currently busy\');"' : '' }}>
                                {{ $provider->is_available ? 'Book Now' : 'Not Available' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.172 16.172a4 4 0 015.656 0M9 10a4 4 0 018 0m0 0a4 4 0 01-5.656 5.656m5.656-5.656a4 4 0 010-5.656m0 5.656l2.828-2.829m-5.656 0l2.829-2.828" />
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No providers found</h3>
                            <p class="text-gray-600 mb-4">Try adjusting your search filters or explore all available
                                providers</p>
                            <a href="{{ route('customer.search') }}"
                                class="text-indigo-600 hover:text-indigo-800 font-medium">
                                Clear filters and try again →
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($providers->total() > 0)
                <div class="mt-8">
                    {{ $providers->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>