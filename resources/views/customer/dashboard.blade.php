<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">Find trusted local service providers for all your needs.</p>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-4">Find a Service Provider</h3>
                    
                    <form action="{{ route('customer.search') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Search Input -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search by Name</label>
                                <input type="text" name="search" id="search" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Enter provider name...">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category_id" id="category_id" 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Locations</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}">{{ $location }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
                                Search Providers
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">My Bookings</h3>
                        <p class="text-gray-600 mb-4">View and manage your service bookings</p>
                        <a href="{{ route('customer.bookings') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            View All Bookings →
                        </a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Browse Services</h3>
                        <p class="text-gray-600 mb-4">Explore all available service providers</p>
                        <a href="{{ route('customer.search') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Browse All →
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>