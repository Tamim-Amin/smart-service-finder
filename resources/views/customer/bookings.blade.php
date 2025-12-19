<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-6">Booking History</h3>

                    @forelse($bookings as $booking)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <img src="{{ $booking->provider->user->profile_photo_url }}" 
                                             alt="{{ $booking->provider->user->name }}" 
                                             class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 mr-3">
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $booking->provider->user->name }}</h4>
                                            <span class="text-sm text-gray-600">{{ $booking->provider->category->name }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p><strong>Date:</strong> {{ $booking->service_date->format('M d, Y') }}</p>
                                        <p><strong>Time:</strong> {{ date('g:i A', strtotime($booking->service_time)) }}</p>
                                        <p><strong>Location:</strong> {{ $booking->provider->location }}</p>
                                        <p><strong>Problem:</strong> {{ $booking->problem_description }}</p>
                                        
                                        @if(isset($booking->total_hours) && isset($booking->total_amount))
                                            <p class="text-green-600 font-semibold mt-2">
                                                💰 Total Cost: ৳{{ number_format($booking->total_amount, 0) }} ({{ $booking->total_hours }} hours)
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="ml-4">
                                    @if($booking->status == 'pending')
                                        <span class="bg-yellow-100 text-yellow-800 text-sm px-3 py-1 rounded-full">Pending</span>
                                    @elseif($booking->status == 'accepted')
                                        <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">Accepted</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">Completed</span>
                                    @elseif($booking->status == 'rejected')
                                        <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">Rejected</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Chat Button - Only show for ACCEPTED bookings -->
                            @if($booking->status == 'accepted')
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('chat.show', $booking->id) }}" 
                                       class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        Chat with {{ $booking->provider->user->name }}
                                        @if($booking->unreadMessagesFor(Auth::id()) > 0)
                                            <span class="ml-2 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">
                                                {{ $booking->unreadMessagesFor(Auth::id()) }}
                                            </span>
                                        @endif
                                    </a>
                                </div>
                            @endif

                            <!-- Review Section - Only for completed bookings -->
                            @if($booking->status == 'completed' && !$booking->review)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <a href="{{ route('reviews.create', $booking->id) }}" 
                                        class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                                        Write a Review
                                    </a>
                                </div>
                            @endif

                            @if($booking->review)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm font-semibold mb-1">Your Review:</p>
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $booking->review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $booking->review->comment }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No bookings yet. Start by searching for service providers!</p>
                    @endforelse

                    <div class="mt-6">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>