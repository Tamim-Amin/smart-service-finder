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
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden" style="height: calc(100vh - 200px);">
                
                <div id="messages-container" class="p-4 overflow-y-auto" style="height: calc(100% - 80px);">
                    @foreach($messages as $message)
                        @include('chat.partials.message-bubble', ['message' => $message])
                    @endforeach
                </div>

                <div class="border-t border-gray-200 p-4 bg-gray-50">
                    <form id="chat-form" class="flex items-center space-x-2">
                        @csrf
                        <input type="text" 
                               name="message" 
                               id="message-input"
                               placeholder="Type a message..." 
                               required
                               autocomplete="off"
                               class="flex-1 rounded-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-2">
                        <button type="submit" 
                                id="send-btn"
                                class="bg-indigo-600 text-white rounded-full p-3 hover:bg-indigo-700 transition disabled:opacity-50">
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
        const container = document.getElementById('messages-container');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message-input');
        const sendBtn = document.getElementById('send-btn');
        
        // Track the ID of the last message we have
        let lastMessageId = {{ $messages->count() ? $messages->last()->id : 0 }};
        const currentUserId = {{ Auth::id() }};
        const bookingId = {{ $booking->id }};

        // Scroll to bottom helper
        function scrollToBottom() {
            container.scrollTop = container.scrollHeight;
        }

        // 1. SEND MESSAGE via AJAX
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            // Disable button temporarily
            sendBtn.disabled = true;
            input.value = ''; // Clear input immediately for better UX

            fetch(`{{ url('/chat') }}/${bookingId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json' // Expect JSON back
                },
                body: JSON.stringify({ message: message })
            })
            .then(() => {
                // We don't need to append manually here because the 
                // polling function below will pick it up in < 2 seconds
                sendBtn.disabled = false;
                fetchNewMessages(); // Trigger immediate fetch
            })
            .catch(error => {
                console.error('Error:', error);
                sendBtn.disabled = false;
                alert('Failed to send message.');
            });
        });

        // 2. FETCH NEW MESSAGES via AJAX (Polling)
        function fetchNewMessages() {
            fetch(`{{ url('/chat') }}/${bookingId}/messages?last_id=${lastMessageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            appendMessage(msg);
                            lastMessageId = msg.id; // Update our tracker
                        });
                        scrollToBottom();
                    }
                })
                .catch(err => console.error(err));
        }

        // Helper to create HTML for new messages
        function appendMessage(msg) {
            // 1. Check if ID exists
            if (document.getElementById(`message-${msg.id}`)) {
                return; // Stop if we already have this message
            }

            const isMe = msg.sender_id === currentUserId;
            const date = new Date(msg.created_at);
            const timeStr = date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });

            // 2. ADD THE ID ATTRIBUTE HERE inside the div tag
            const html = `
                <div id="message-${msg.id}" class="mb-4 flex ${isMe ? 'justify-end' : 'justify-start'}">
                    <div class="flex ${isMe ? 'flex-row-reverse' : 'flex-row'} items-end max-w-[70%]">
                        <img src="${msg.sender.profile_photo_url}" 
                             class="w-8 h-8 rounded-full object-cover ${isMe ? 'ml-2' : 'mr-2'}">
                        <div>
                            <div class="px-4 py-2 rounded-2xl ${isMe ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-900'}">
                                <p class="text-sm break-words">${msg.message}</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 ${isMe ? 'text-right' : 'text-left'}">
                                ${timeStr}
                            </p>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        // Initial setup
        scrollToBottom();
        // Poll every 2 seconds
        setInterval(fetchNewMessages, 2000);
    </script>
</x-app-layout>