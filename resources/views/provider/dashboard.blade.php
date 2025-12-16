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

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Total Bookings</p>
                        <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_bookings'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Pending</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Accepted</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['accepted'] }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['completed'] }}</p>
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
                                <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Verified</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">Pending Verification</span>
                            @endif
                            
                            @if($provider->is_available)
                                <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Available</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">Unavailable</span>
                            @endif
                            
                            <a href="{{ route('provider.profile.edit') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
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
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold mb-2">{{ $booking->customer->name }}</h4>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><strong>Date:</strong> {{ $booking->service_date->format('M d, Y') }}</p>
                                        <p><strong>Time:</strong> {{ date('g:i A', strtotime($booking->service_time)) }}</p>
                                        <p><strong>Problem:</strong> {{ $booking->problem_description }}</p>
                                        <p><strong>Contact:</strong> {{ $booking->customer->email }}</p>
                                        <p class="text-xs text-gray-500 mt-2">Requested: {{ $booking->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <div class="ml-4 flex flex-col items-end space-y-2">
                                    @if($booking->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">Pending</span>
                                        <div class="flex space-x-2 mt-2">
                                            <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded text-sm hover:bg-green-700 transition">
                                                    Accept
                                                </button>
                                            </form>
                                            <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded text-sm hover:bg-red-700 transition">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($booking->status == 'accepted')
                                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Accepted</span>
                                        <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700 transition">
                                                Mark Complete
                                            </button>
                                        </form>
                                    @elseif($booking->status == 'completed')
                                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Completed</span>
                                        @if($booking->review)
                                            <div class="mt-2 text-right">
                                                <div class="flex items-center justify-end mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                @if($booking->review->comment)
                                                    <p class="text-xs text-gray-600 italic max-w-xs">
                                                        "{{ Str::limit($booking->review->comment, 60) }}"
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    @elseif($booking->status == 'rejected')
                                        <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">Rejected</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="bg-gray-100 text-gray-800 text-sm px-3 py-1 rounded-full">Cancelled</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 mt-2">No booking requests yet</p>
                            <p class="text-sm text-gray-400 mt-1">When customers book your service, requests will appear here</p>
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