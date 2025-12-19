<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Provider Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
                <!-- Total Earnings Card - Clickable -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 overflow-hidden shadow-lg sm:rounded-lg cursor-pointer hover:shadow-xl transition transform hover:scale-105"
                     onclick="window.location='{{ route('provider.earnings') }}'">
                    <div class="p-6 text-white">
                        <div class="flex justify-between items-start mb-2">
                            <p class="text-sm opacity-90">Total Earnings</p>
                            <svg class="w-5 h-5 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <p class="text-3xl font-bold mb-1">৳{{ number_format($provider->total_earnings ?? 0, 0) }}</p>
                        <p class="text-xs opacity-75">Click for detailed summary</p>
                    </div>
                </div>

                <!-- Total Bookings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_bookings'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Accepted -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Accepted</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['accepted'] ?? 0 }}</p>
                    </div>
                </div>

                <!-- Completed -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['completed'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Provider Profile Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-xl font-semibold mb-2">{{ Auth::user()->name }}</h3>
                            <p class="text-indigo-600 font-medium mb-2">{{ $provider->category->name }}</p>
                            <p class="text-sm text-gray-600 mb-3">{{ $provider->bio }}</p>
                            
                            <div class="flex items-center space-x-4 text-sm">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-400 fill-current mr-1" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <span class="font-semibold">{{ number_format($provider->average_rating, 1) }}</span>
                                    <span class="text-gray-500 ml-1">({{ $provider->total_reviews }} reviews)</span>
                                </div>
                                <div class="text-green-600 font-bold">
                                    ৳{{ number_format($provider->hourly_rate, 0) }}/hr
                                </div>
                                <div>
                                    {{ $provider->experience_years }} years experience
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $provider->location }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col items-end space-y-2">
                            @if($provider->is_verified)
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">✓ Verified</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">⏳ Pending Verification</span>
                            @endif
                            
                            @if($provider->is_available)
                                <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">✓ Available</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">✗ Unavailable</span>
                            @endif
                            
                            <a href="{{ route('provider.earnings') }}" class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                View Earnings Summary →
                            </a>
                            
                            <a href="{{ route('provider.profile.edit') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Profile →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bookings List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Booking Requests</h3>

                    @forelse($bookings as $booking)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4 {{ $booking->status == 'completed' ? 'bg-green-50' : '' }} hover:shadow-md transition">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <!-- Customer Profile Photo and Name -->
                                    <div class="flex items-center mb-3">
                                        <img src="{{ $booking->customer->profile_photo_url }}" 
                                             alt="{{ $booking->customer->name }}" 
                                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mr-3">
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $booking->customer->name }}</h4>
                                            <span class="text-sm text-gray-500">{{ $booking->customer->email }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 space-y-1 ml-15">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <strong>Date:</strong> <span class="ml-1">{{ $booking->service_date->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <strong>Time:</strong> <span class="ml-1">{{ date('g:i A', strtotime($booking->service_time)) }}</span>
                                        </div>
                                        <div class="flex items-start">
                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <div>
                                                <strong>Problem:</strong>
                                                <p class="text-gray-700 mt-1">{{ $booking->problem_description }}</p>
                                            </div>
                                        </div>
                                        
                                        @if(isset($booking->total_hours) && isset($booking->total_amount))
                                            <div class="flex items-center mt-2 pt-2 border-t border-gray-200">
                                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-green-600 font-semibold">
                                                    Earned: ৳{{ number_format($booking->total_amount, 0) }} ({{ $booking->total_hours }} {{ $booking->total_hours > 1 ? 'hours' : 'hour' }})
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <p class="text-xs text-gray-500 mt-2">
                                            Requested: {{ $booking->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                <div class="ml-4 flex flex-col items-end space-y-2 min-w-[180px]">
                                    @if($booking->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full font-medium">⏳ Pending</span>
                                        <div class="flex flex-col space-y-2 mt-2 w-full">
                                            <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700 transition flex items-center justify-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($booking->status == 'accepted')
                                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">✓ Accepted</span>
                                        
                                        <!-- Chat Button -->
                                        <a href="{{ route('chat.show', $booking->id) }}" 
                                           class="mt-2 w-full bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            Chat with Customer
                                            @if($booking->unreadMessagesFor(Auth::id()) > 0)
                                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                                                    {{ $booking->unreadMessagesFor(Auth::id()) }}
                                                </span>
                                            @endif
                                        </a>
                                        
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="mt-2 w-full">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <div class="mb-2">
                                                <label class="block text-xs text-gray-600 mb-1 font-medium">Total Hours Worked:</label>
                                                <input type="number" name="total_hours" min="1" max="24" required
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    placeholder="Enter hours">
                                            </div>
                                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center justify-center font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Mark Complete
                                            </button>
                                        </form>
                                    @elseif($booking->status == 'completed')
                                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full font-medium">✓ Completed</span>
                                        @if(isset($booking->review))
                                            <div class="mt-2 text-right">
                                                <p class="text-xs text-gray-600 mb-1">Customer Review:</p>
                                                <div class="flex items-center justify-end mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                @if($booking->review->comment)
                                                    <p class="text-xs text-gray-600 italic max-w-xs bg-gray-50 p-2 rounded">
                                                        "{{ Str::limit($booking->review->comment, 80) }}"
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <p class="text-xs text-gray-500 mt-2">Awaiting customer review</p>
                                        @endif
                                    @elseif($booking->status == 'rejected')
                                        <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full font-medium">✗ Rejected</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full font-medium">✗ Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">No booking requests yet</h3>
                            <p class="text-sm text-gray-500 mt-2">When customers book your service, requests will appear here</p>
                            @if(!$provider->is_verified)
                                <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-4 inline-block">
                                    <p class="text-sm text-yellow-800">
                                        <strong>Note:</strong> Your profile is pending verification. Once verified by admin, you'll start receiving bookings.
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endforelse

                    @if($bookings->count() > 0)
                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>