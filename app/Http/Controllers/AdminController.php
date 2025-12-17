<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Provider;
use App\Models\Category;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_providers' => Provider::count(),
            'pending_verifications' => Provider::where('is_verified', false)->count(),
            'total_bookings' => Booking::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function providers()
    {
        $providers = Provider::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.providers', compact('providers'));
    }

    public function verifyProvider($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->update(['is_verified' => !$provider->is_verified]);

        $message = $provider->is_verified
            ? 'Provider verified successfully!'
            : 'Provider verification removed!';

        return back()->with('success', $message);
    }

    public function deleteProvider($id)
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();

        return back()->with('success', 'Provider deleted successfully!');
    }

    public function categories()
    {
        $categories = Category::withCount('providers')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create($validated);

        return back()->with('success', 'Category created successfully!');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return back()->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        if ($category->providers()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing providers.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }

    public function users()
    {
        $users = User::with('userRole')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully!');
    }

    public function logs()
    {
        // This is for future implementation of system logs
        return view('admin.logs');
    }
}
