<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    public function edit()
    {
        return view('profile.photo');
    }

    public function update(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        // Update user
        $user->update([
            'profile_photo' => $path
        ]);

        // FIX: This check must be here in ProfilePhotoController
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true, 
                'path' => $path,
                'url' => asset('storage/' . $path)
            ]);
        }

        return back()->with('success', 'Profile photo updated successfully!');
    }

    public function destroy()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'Profile photo removed successfully!');
    }
}