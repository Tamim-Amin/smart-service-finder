<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\Category;

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
        $query = Provider::with(['user', 'category'])->where('is_verified', true);

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->location) {
            $query->where('location', $request->location);
        }
        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $providers = $query->orderBy('average_rating', 'desc')->paginate(12);
        return view('customer.search', compact('providers'));
    }
}
