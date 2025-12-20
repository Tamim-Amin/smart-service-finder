<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl md:text-3xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600">
                Welcome back, {{ Auth::user()->name }} 👋
            </div>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Section with Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-lg shadow-lg p-6 md:p-8 mb-8 text-white">
                <h3 class="text-2xl md:text-3xl font-bold mb-2">System Overview</h3>
                <p class="text-indigo-100 md:text-lg">Monitor and manage your platform at a glance</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-indigo-600">
                    <div class="p-5 md:p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs md:text-sm text-gray-600 font-semibold mb-2">TOTAL USERS</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                                <p class="text-xs text-gray-500 mt-2">Active platform users</p>
                            </div>
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-indigo-100" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v-2a9 9 0 00-18 0v2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Providers -->
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-green-600">
                    <div class="p-5 md:p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs md:text-sm text-gray-600 font-semibold mb-2">TOTAL PROVIDERS</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_providers'] }}
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Service providers</p>
                            </div>
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-green-100" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Verifications -->
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-yellow-600">
                    <div class="p-5 md:p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs md:text-sm text-gray-600 font-semibold mb-2">PENDING VERIFICATIONS</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-800">
                                    {{ $stats['pending_verifications'] }}</p>
                                <p class="text-xs text-gray-500 mt-2">Awaiting verification</p>
                            </div>
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-yellow-100" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow border-l-4 border-blue-600">
                    <div class="p-5 md:p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs md:text-sm text-gray-600 font-semibold mb-2">TOTAL BOOKINGS</p>
                                <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $stats['total_bookings'] }}
                                </p>
                                <p class="text-xs text-gray-500 mt-2">Service bookings</p>
                            </div>
                            <svg class="w-8 h-8 md:w-12 md:h-12 text-blue-100" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Manage Providers -->
                <a href="{{ route('admin.providers') }}" class="group">
                    <div
                        class="bg-white rounded-lg shadow hover:shadow-xl transition-all duration-200 overflow-hidden border-t-4 border-green-500">
                        <div class="p-6 md:p-8">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <h3
                                class="text-lg md:text-xl font-bold text-gray-800 mb-2 group-hover:text-green-600 transition">
                                Manage Providers</h3>
                            <p class="text-gray-600 text-sm md:text-base">Verify and manage service providers, check
                                their ratings and earnings</p>
                            <div
                                class="mt-4 flex items-center text-green-600 font-semibold text-sm group-hover:translate-x-1 transition">
                                View All →
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Manage Categories -->
                <a href="{{ route('admin.categories') }}" class="group">
                    <div
                        class="bg-white rounded-lg shadow hover:shadow-xl transition-all duration-200 overflow-hidden border-t-4 border-indigo-500">
                        <div class="p-6 md:p-8">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                            </div>
                            <h3
                                class="text-lg md:text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition">
                                Manage Categories</h3>
                            <p class="text-gray-600 text-sm md:text-base">Add, edit, or remove service categories and
                                manage their status</p>
                            <div
                                class="mt-4 flex items-center text-indigo-600 font-semibold text-sm group-hover:translate-x-1 transition">
                                View All →
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Manage Users -->
                <a href="{{ route('admin.users') }}" class="group">
                    <div
                        class="bg-white rounded-lg shadow hover:shadow-xl transition-all duration-200 overflow-hidden border-t-4 border-purple-500">
                        <div class="p-6 md:p-8">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <h3
                                class="text-lg md:text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-600 transition">
                                Manage Users</h3>
                            <p class="text-gray-600 text-sm md:text-base">View all users, manage roles, and handle user
                                accounts</p>
                            <div
                                class="mt-4 flex items-center text-purple-600 font-semibold text-sm group-hover:translate-x-1 transition">
                                View All →
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>