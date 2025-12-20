<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Provider Dashboard') }}
            </h2>
            <a href="{{ route('provider.profile.edit') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Profile
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
            @endif

            <!-- Welcome Section with Provider Info -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-lg shadow-lg p-8 mb-8 text-white">
                <div class="flex justify-between items-start">
                    <div class="flex items-center">

                        <div>
                            <h3 class="text-3xl font-bold mb-1">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                            <p class="text-indigo-100 mb-3">{{ $provider->category->name }} • {{ $provider->location }}
                            </p>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-300 fill-current mr-1" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                    <span class="font-bold">{{ number_format($provider->average_rating, 1) }}</span>
                                    <span class="text-indigo-100 ml-1">({{ $provider->total_reviews }} reviews)</span>
                                </div>
                                <div class="text-indigo-100">৳{{ number_format($provider->hourly_rate, 0) }}/hour</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-2">
                        @if($provider->is_verified)
                        <span
                            class="bg-white text-green-700 text-sm px-3 py-1 rounded-full font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Verified
                        </span>
                        @else
                        <span class="bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded-full font-medium">⏳
                            Pending</span>
                        @endif
                        @if($provider->is_available)
                        <span
                            class="bg-white text-indigo-700 text-sm px-3 py-1 rounded-full font-medium flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            Available
                        </span>
                        @else
                        <span class="bg-gray-200 text-gray-700 text-sm px-3 py-1 rounded-full font-medium">✗
                            Unavailable</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <!-- Total Earnings Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-md p-6 text-white cursor-pointer hover:shadow-lg transform hover:scale-105 transition"
                    onclick="window.location='{{ route('provider.earnings') }}'">
                    <div class="flex justify-between items-start mb-2">
                        <p class="text-sm opacity-90">Total Earnings</p>
                        <svg class="w-6 h-6 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-3xl font-bold">৳{{ number_format($provider->total_earnings ?? 0, 0) }}</p>
                    <p class="text-xs opacity-75 mt-1">View detailed summary</p>
                </div>

                <!-- Pending Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Pending</p>
                            <p class="text-4xl font-bold text-yellow-600 mt-2">{{ $stats['pending'] ?? 0 }}</p>
                        </div>
                        <svg class="w-8 h-8 text-yellow-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2h16V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Accepted Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Accepted</p>
                            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $stats['accepted'] ?? 0 }}</p>
                        </div>
                        <svg class="w-8 h-8 text-blue-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Completed Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Completed</p>
                            <p class="text-4xl font-bold text-green-600 mt-2">{{ $stats['completed'] ?? 0 }}</p>
                        </div>
                        <svg class="w-8 h-8 text-green-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 1 1 0 000-2H6a4 4 0 014 4v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm12.707 5.293a1 1 0 00-1.414-1.414L9 12.586 7.707 11.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-500 hover:shadow-lg transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Bookings</p>
                            <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $stats['total_bookings'] ?? 0 }}</p>
                        </div>
                        <svg class="w-8 h-8 text-indigo-500 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM15 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2h-2zM5 13a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Booking Requests Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Service Requests
                    </h3>
                </div>

                <div class="p-6 space-y-4">
                    @forelse($bookings as $booking)
                    <div
                        class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-200">
                        <!-- Card Header with Status -->
                        <div
                            class="bg-gradient-to-r {{ 
                                                                                                                $booking->status === 'pending' ? 'from-yellow-50 to-yellow-100' :
                        ($booking->status === 'accepted' ? 'from-blue-50 to-blue-100' : 'from-green-50 to-green-100') 
                                                                                                            }} p-4 border-b border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $booking->customer->profile_photo_url }}"
                                        alt="{{ $booking->customer->name }}"
                                        class="w-14 h-14 rounded-full object-cover border-2 border-white shadow-sm">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-800">{{ $booking->customer->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->customer->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($booking->status === 'pending')
                                    <span
                                        class="inline-block bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full">⏳
                                        PENDING</span>
                                    @elseif($booking->status === 'accepted')
                                    <span
                                        class="inline-block bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full">✓
                                        ACCEPTED</span>
                                    @else
                                    <span
                                        class="inline-block bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full">✓
                                        COMPLETED</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-2 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">DATE</p>
                                            <p class="text-sm font-bold text-gray-800">
                                                {{ $booking->service_date->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">TIME</p>
                                            <p class="text-sm font-bold text-gray-800">
                                                {{ date('g:i A', strtotime($booking->service_time)) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">DURATION</p>
                                            <p class="text-sm font-bold text-gray-800">
                                                {{ $booking->estimated_duration }} hour(s)
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-600 font-semibold">RATE</p>
                                            <p class="text-sm font-bold text-gray-800">
                                                ৳{{ number_format($provider->hourly_rate, 0) }}/hr</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <p class="text-xs text-gray-600 font-semibold mb-2">ISSUE</p>
                                    <p class="text-sm text-gray-700">{{ $booking->problem_description }}</p>
                                </div>

                                @if(isset($booking->total_amount))
                                <div class="flex items-center space-x-4 pt-4 border-t border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-600 font-semibold">ESTIMATED COST</p>
                                        <p class="text-lg font-bold text-green-600">
                                            ৳{{ number_format($booking->total_amount, 0) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 font-semibold">HOURS</p>
                                        <p class="text-lg font-bold text-gray-800">{{ $booking->total_hours }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-3">
                                @if($booking->status === 'pending')
                                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit"
                                        class="w-full bg-gray-400 text-white font-bold py-3 rounded-lg hover:bg-red-600 hover:shadow-lg transform hover:scale-105 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </form>
                                @elseif($booking->status === 'accepted')
                                @if($booking->payment_status === 'paid')
                                <div class="bg-green-50 border-2 border-green-300 rounded-lg p-3 text-center mb-2">
                                    <p class="text-xs font-bold text-green-700 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        PAYMENT RECEIVED
                                    </p>
                                </div>
                                <a href="{{ route('chat.show', $booking->id) }}"
                                    class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Chat
                                </a>
                                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Complete Work
                                    </button>
                                </form>
                                @else
                                <div class="bg-orange-50 border-2 border-orange-300 rounded-lg p-3 text-center mb-2">
                                    <p class="text-xs font-bold text-orange-700">⏳ AWAITING PAYMENT</p>
                                </div>
                                <a href="{{ route('chat.show', $booking->id) }}"
                                    class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transform hover:scale-105 transition flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Chat
                                </a>
                                @endif
                                @else
                                <div class="bg-green-100 rounded-lg p-4 text-center">
                                    <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <p class="text-green-700 font-bold">Service Completed</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">No booking requests yet</h3>
                        <p class="text-gray-600 mt-2">You don't have any booking requests at the moment.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>