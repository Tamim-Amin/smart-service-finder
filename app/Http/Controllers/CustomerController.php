<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Category;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $categories = Category::where('is_active', true)->get();
        $locations = Provider::select('location')->distinct()->pluck('location');
        
        return view('customer.dashboard', compact('categories', 'locations'));
    }

    public function searchProviders(Request $request)
    {
        $query = Provider::with(['user', 'category'])
            ->where('is_verified', true);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->location) {
            $query->where('location', $request->location);
        }

        if ($request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $providers = $query->orderBy('average_rating', 'desc')->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $locations = Provider::select('location')->distinct()->pluck('location');

        return view('customer.search', compact('providers', 'categories', 'locations'));
    }

    public function myBookings()
    {
        $bookings = Booking::with(['provider.user', 'provider.category', 'review'])
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.bookings', compact('bookings'));
    }

    public function viewProvider($id)
    {
        $provider = Provider::with(['user', 'category', 'reviews.customer'])
            ->findOrFail($id);

        return view('customer.provider-detail', compact('provider'));
    }

    public function browseProviders(Request $request)
    {
        $query = Provider::with(['user', 'category'])
            ->where('is_verified', true);

        $providers = $query->orderBy('average_rating', 'desc')->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('customer.browse', compact('providers', 'categories'));
    }
}