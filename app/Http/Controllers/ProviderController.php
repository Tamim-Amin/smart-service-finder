<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Category;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderController extends Controller
{
    public function dashboard()
    {
        $provider = Provider::where('user_id', Auth::id())->first();
        
        if (!$provider) {
            return redirect()->route('provider.profile.create');
        }

        $stats = [
            'total_bookings' => Booking::where('provider_id', $provider->id)->count(),
            'pending' => Booking::where('provider_id', $provider->id)->where('status', 'pending')->count(),
            'accepted' => Booking::where('provider_id', $provider->id)->where('status', 'accepted')->count(),
            'completed' => Booking::where('provider_id', $provider->id)->where('status', 'completed')->count(),
        ];

        $bookings = Booking::with(['customer', 'review'])
            ->where('provider_id', $provider->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('provider.dashboard', compact('provider', 'stats', 'bookings'));
    }

    public function createProfile()
    {
        // Check if provider profile already exists
        $existingProvider = Provider::where('user_id', Auth::id())->first();
        
        if ($existingProvider) {
            return redirect()->route('provider.dashboard');
        }

        $categories = Category::where('is_active', true)->get();
        return view('provider.profile-create', compact('categories'));
    }

    public function storeProfile(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'bio' => 'required|string|max:1000',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
        ]);

        Provider::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'bio' => $validated['bio'],
            'experience_years' => $validated['experience_years'],
            'hourly_rate' => $validated['hourly_rate'],
            'location' => $validated['location'],
        ]);

        return redirect()->route('provider.dashboard')->with('success', 'Profile created successfully!');
    }

    public function editProfile()
    {
        $provider = Provider::where('user_id', Auth::id())->firstOrFail();
        $categories = Category::where('is_active', true)->get();
        
        return view('provider.profile-edit', compact('provider', 'categories'));
    }

    public function updateProfile(Request $request)
    {
        $provider = Provider::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'bio' => 'required|string|max:1000',
            'experience_years' => 'required|integer|min:0',
            'hourly_rate' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available') ? true : false;

        $provider->update($validated);

        return redirect()->route('provider.dashboard')->with('success', 'Profile updated successfully!');
    }
}
