<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Total Users</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Total Providers</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['total_providers'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Pending Verifications</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending_verifications'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_bookings'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <a href="{{ route('admin.providers') }}" class="block p-6">
                        <h3 class="text-lg font-semibold mb-2">Manage Providers</h3>
                        <p class="text-gray-600">Verify and manage service providers</p>
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <a href="{{ route('admin.categories') }}" class="block p-6">
                        <h3 class="text-lg font-semibold mb-2">Manage Categories</h3>
                        <p class="text-gray-600">Add, edit, or remove service categories</p>
                    </a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                    <a href="{{ route('admin.users') }}" class="block p-6">
                        <h3 class="text-lg font-semibold mb-2">Manage Users</h3>
                        <p class="text-gray-600">View and manage all users</p>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>