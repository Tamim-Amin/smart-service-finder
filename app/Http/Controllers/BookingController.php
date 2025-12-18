<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Provider;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($providerId)
    {
        $provider = Provider::with(['user', 'category'])->findOrFail($providerId);
        
        if (!$provider->is_available) {
            return redirect()->back()->with('error', 'This provider is currently not available.');
        }

        return view('bookings.create', compact('provider'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'problem_description' => 'required|string|max:1000',
            'service_date' => 'required|date|after_or_equal:today',
            'service_time' => 'required',
        ]);

        $booking = Booking::create([
            'customer_id' => Auth::id(),
            'provider_id' => $validated['provider_id'],
            'problem_description' => $validated['problem_description'],
            'service_date' => $validated['service_date'],
            'service_time' => $validated['service_time'],
            'status' => 'pending',
        ]);

        // Get provider user
        $provider = Provider::with('user')->findOrFail($validated['provider_id']);

        // Create notification for provider
        Notification::create([
            'user_id' => $provider->user_id,
            'type' => 'booking_request',
            'title' => 'New Booking Request',
            'message' => Auth::user()->name . ' has requested your service for ' . $validated['service_date'],
            'booking_id' => $booking->id,
        ]);

        return redirect()->route('customer.bookings')->with('success', 'Booking request sent successfully!');
    }

    public function updateStatus(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $provider = Provider::where('user_id', Auth::id())->firstOrFail();

        if ($booking->provider_id !== $provider->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected,completed',
            'total_hours' => 'nullable|required_if:status,completed|integer|min:1',
        ]);

        // If marking as completed, calculate earnings
        if ($validated['status'] === 'completed') {
            $totalHours = $validated['total_hours'];
            $totalAmount = $totalHours * $provider->hourly_rate;

            // Update booking with amount and hours
            $booking->update([
                'status' => 'completed',
                'total_hours' => $totalHours,
                'total_amount' => $totalAmount,
            ]);

            // Update provider's total earnings
            $provider->increment('total_earnings', $totalAmount);

            // Create notification for customer
            Notification::create([
                'user_id' => $booking->customer_id,
                'type' => 'booking_completed',
                'title' => 'Service Completed',
                'message' => 'Your booking with ' . Auth::user()->name . ' has been completed. Total: ৳' . number_format($totalAmount, 0),
                'booking_id' => $booking->id,
            ]);

            return back()->with('success', "Service completed! Earned: ৳{$totalAmount} ({$totalHours} hours × ৳{$provider->hourly_rate}/hr)");
        }

        // Update booking status
        $booking->update(['status' => $validated['status']]);

        // Create notification for customer
        if ($validated['status'] === 'accepted') {
            Notification::create([
                'user_id' => $booking->customer_id,
                'type' => 'booking_accepted',
                'title' => 'Booking Accepted',
                'message' => Auth::user()->name . ' has accepted your booking request for ' . $booking->service_date->format('M d, Y'),
                'booking_id' => $booking->id,
            ]);
        } elseif ($validated['status'] === 'rejected') {
            Notification::create([
                'user_id' => $booking->customer_id,
                'type' => 'booking_rejected',
                'title' => 'Booking Rejected',
                'message' => Auth::user()->name . ' has rejected your booking request. Please try booking another provider.',
                'booking_id' => $booking->id,
            ]);
        }

        return back()->with('success', 'Booking status updated successfully!');
    }

    public function cancel($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully!');
    }
}