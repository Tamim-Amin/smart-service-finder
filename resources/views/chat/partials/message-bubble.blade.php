<div id="message-{{ $message->id }}" class="mb-4 flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
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