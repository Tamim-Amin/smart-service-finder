<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function show($bookingId)
    {
        $booking = Booking::with(['customer', 'provider.user', 'messages.sender'])
            ->findOrFail($bookingId);

        // Check authorization
        $userId = Auth::id();
        $isCustomer = $booking->customer_id === $userId;
        $isProvider = $booking->provider->user_id === $userId;

        if (!$isCustomer && !$isProvider) {
            abort(403, 'Unauthorized access to this chat.');
        }

        // Only allow chat for ACCEPTED bookings (not completed, rejected, or cancelled)
        if ($booking->status !== 'accepted') {
            if ($booking->status === 'completed') {
                return redirect()->back()->with('error', 'Chat is closed. The service has been completed.');
            } elseif ($booking->status === 'rejected') {
                return redirect()->back()->with('error', 'Chat is not available for rejected bookings.');
            } elseif ($booking->status === 'cancelled') {
                return redirect()->back()->with('error', 'Chat is not available for cancelled bookings.');
            } else {
                return redirect()->back()->with('error', 'Chat is only available for accepted bookings.');
            }
        }

        // Mark messages as read
        $booking->messages()
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $booking->messages;
        
        // Determine the other user
        $otherUser = $isCustomer ? $booking->provider->user : $booking->customer;

        return view('chat.show', compact('booking', 'messages', 'otherUser', 'isCustomer'));
    }

    public function store(Request $request, $bookingId)
    {
        $booking = Booking::with(['customer', 'provider.user'])->findOrFail($bookingId);

        $userId = Auth::id();
        $isCustomer = $booking->customer_id === $userId;
        $isProvider = $booking->provider->user_id === $userId;

        if (!$isCustomer && !$isProvider) {
            abort(403);
        }

        // Block messaging if booking is completed
        if ($booking->status !== 'accepted') {
            return redirect()->back()->with('error', 'Cannot send messages. Booking is ' . $booking->status . '.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Determine receiver
        $receiverId = $isCustomer ? $booking->provider->user_id : $booking->customer_id;

        Message::create([
            'booking_id' => $bookingId,
            'sender_id' => $userId,
            'receiver_id' => $receiverId,
            'message' => $validated['message'],
        ]);

        return redirect()->route('chat.show', $bookingId);
    }

   public function getMessages(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $userId = Auth::id();

        // Check authorization
        if ($booking->customer_id !== $userId && $booking->provider->user_id !== $userId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Get the last message ID the client already has
        $lastId = $request->query('last_id', 0);

        // Fetch only NEW messages created after that ID
        $messages = $booking->messages()
            ->with('sender')
            ->where('id', '>', $lastId) // Critical change here
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark them as read
        if ($messages->isNotEmpty()) {
            $booking->messages()
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->whereIn('id', $messages->pluck('id'))
                ->update(['is_read' => true]);
        }

        return response()->json([
            'messages' => $messages,
            'current_user_id' => $userId
        ]);
    }
}