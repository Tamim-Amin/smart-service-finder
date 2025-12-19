<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ Auth::user()->isProvider() ? route('provider.dashboard') : route('customer.bookings') }}" 
               class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <img src="{{ $otherUser->profile_photo_url }}" 
                 alt="{{ $otherUser->name }}" 
                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 mr-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $otherUser->name }}
                </h2>
                <p class="text-sm text-gray-600">
                    {{ $isCustomer ? $booking->provider->category->name : 'Customer' }} • 
                    Service on {{ $booking->service_date->format('M d, Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Chat Container -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden" style="height: calc(100vh - 200px);">
                
                <!-- Messages Area -->
                <div id="messages-container" class="p-4 overflow-y-auto" style="height: calc(100% - 80px);">
                    @forelse($messages as $message)
                        <div class="mb-4 flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="flex {{ $message->sender_id === Auth::id() ? 'flex-row-reverse' : 'flex-row' }} items-end max-w-[70%]">
                                <img src="{{ $message->sender->profile_photo_url }}" 
                                     alt="{{ $message->sender->name }}" 
                                     class="w-8 h-8 rounded-full object-cover {{ $message->sender_id === Auth::id() ? 'ml-2' : 'mr-2' }}">
                                <div>
                                    <div class="px-4 py-2 rounded-2xl {{ $message->sender_id === Auth::id() 
                                        ? 'bg-indigo-600 text-white' 
                                        : 'bg-gray-200 text-gray-900' }}">
                                        <p class="text-sm break-words">{{ $message->message }}</p>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 {{ $message->sender_id === Auth::id() ? 'text-right' : 'text-left' }}">
                                        {{ $message->created_at->format('g:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="text-gray-500 mt-2">No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="border-t border-gray-200 p-4 bg-gray-50">
                    <form action="{{ route('chat.store', $booking->id) }}" method="POST" id="message-form" class="flex items-center space-x-2">
                        @csrf
                        <input type="text" 
                               name="message" 
                               id="message-input"
                               placeholder="Type a message..." 
                               required
                               autocomplete="off"
                               class="flex-1 rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2">
                        <button type="submit" 
                                class="bg-indigo-600 text-white rounded-full p-3 hover:bg-indigo-700 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </div>

    <script>
        // Auto-scroll to bottom
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }

        // Scroll on page load
        window.addEventListener('load', scrollToBottom);

        // Auto-refresh messages every 3 seconds
        setInterval(function() {
            fetch('{{ route("chat.messages", $booking->id) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        // Reload page if new messages (simple approach)
                        location.reload();
                    }
                });
        }, 3000);

        // Handle form submission
        document.getElementById('message-form').addEventListener('submit', function(e) {
            const input = document.getElementById('message-input');
            if (input.value.trim() === '') {
                e.preventDefault();
            }
        });
    </script>
</x-app-layout>