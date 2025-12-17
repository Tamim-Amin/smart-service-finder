<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Booking;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function create($bookingId)
    {
        $booking = Booking::with('provider.user')->findOrFail($bookingId);
        
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only review completed bookings.');
        }

        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        $review = Review::create([
            'booking_id' => $validated['booking_id'],
            'customer_id' => Auth::id(),
            'provider_id' => $booking->provider_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        // Update provider's average rating
        $this->updateProviderRating($booking->provider_id);

        return redirect()->route('customer.bookings')->with('success', 'Review submitted successfully!');
    }

    private function updateProviderRating($providerId)
    {
        $stats = Review::where('provider_id', $providerId)
            ->select(DB::raw('AVG(rating) as avg_rating, COUNT(*) as total'))
            ->first();

        Provider::where('id', $providerId)->update([
            'average_rating' => round($stats->avg_rating, 2),
            'total_reviews' => $stats->total,
        ]);
    }
}
