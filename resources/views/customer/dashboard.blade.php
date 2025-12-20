<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Dashboard') }}
            </h2>
            <a href="{{ route('customer.search') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Booking
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section with Stats -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-lg p-8 mb-8 text-white">
                <h3 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-indigo-100 mb-6">Find and book trusted service providers in your area</p>
                
                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <p class="text-indigo-100 text-sm">Active Bookings</p>
                        <p class="text-3xl font-bold">{{ $activeBookings ?? 0 }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <p class="text-indigo-100 text-sm">Completed Services</p>
                        <p class="text-3xl font-bold">{{ $completedServices ?? 0 }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-lg p-4">
                        <p class="text-indigo-100 text-sm">Total Spent</p>
                        <p class="text-3xl font-bold">৳{{ number_format($totalSpent ?? 0, 0) }}</p>
                    </div>
                </div>
            </div>

            <!-- Search & Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-xl font-semibold mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Find Service Providers
                </h3>
                
                <form action="{{ route('customer.search') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" id="search" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Provider name, skill...">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category_id" id="category_id" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location Filter -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <select name="location" id="location" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Locations</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition font-medium">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Quick Actions & Recent Activity -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Quick Actions
                        </h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('customer.search') }}" class="block w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-4 py-3 rounded-lg hover:shadow-lg transition text-center font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Book a Service
                            </a>
                            
                            <a href="{{ route('customer.bookings') }}" class="block w-full bg-white border-2 border-indigo-600 text-indigo-600 px-4 py-3 rounded-lg hover:bg-indigo-50 transition text-center font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                My Bookings
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="block w-full bg-gray-100 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-200 transition text-center font-medium">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-sm font-semibold text-blue-900 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                            </svg>
                            Tip
                        </h3>
                        <p class="text-sm text-blue-800">Check provider ratings and reviews before booking to ensure quality service.</p>
                    </div>
                </div>

                <!-- Right Column - Bookings Overview -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Recent Bookings
                            </h3>
                            <a href="{{ route('customer.bookings') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                View All →
                            </a>
                        </div>

                        @if($recentBookings && $recentBookings->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentBookings as $booking)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $booking->provider->user->profile_photo_url }}" 
                                                     alt="{{ $booking->provider->user->name }}" 
                                                     class="w-10 h-10 rounded-full object-cover">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $booking->provider->user->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $booking->provider->category->name }}</p>
                                                </div>
                                            </div>
                                            @if($booking->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-semibold">Pending</span>
                                            @elseif($booking->status == 'accepted')
                                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-semibold">Accepted</span>
                                            @elseif($booking->status == 'completed')
                                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-semibold">Completed</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-semibold">Rejected</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($booking->problem_description, 50) }}</p>
                                        <div class="flex justify-between text-xs text-gray-500">
                                            <span>{{ $booking->service_date->format('M d, Y') }} at {{ date('g:i A', strtotime($booking->service_time)) }}</span>
                                            <span>৳{{ number_format($booking->estimated_cost, 0) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-gray-500 text-sm mt-4">No bookings yet</p>
                                <a href="{{ route('customer.search') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium mt-2 inline-block">
                                    Book your first service →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Featured Services Section -->
            <div class="mt-12">
                <div class="flex items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Top Rated Providers
                    </h3>
                </div>
                <a href="{{ route('customer.search') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Explore all providers →
                </a>
            </div>

        </div>
    </div>
</x-app-layout>