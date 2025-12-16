<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{


    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'problem_description' => 'required|string',
            'service_date' => 'required|date|after_or_equal:today',
            'service_time' => 'required',
        ]);

        Booking::create([
            'customer_id' => Auth::id(),
            'provider_id' => $validated['provider_id'],
            'problem_description' => $validated['problem_description'],
            'service_date' => $validated['service_date'],
            'service_time' => $validated['service_time'],
        ]);

        return redirect()->back()->with('success', 'Booking created!');
    }
}
