<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * ProfileController
 * Manages user profile updates, including contact details and profile pictures.
 */
class ProfileController extends Controller
{
    /**
     * Update the user's profile and contact information.
     */
    /**
     * Execute the update action.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update basic User information
        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profiles', 'public');
            $user->update(['profile_picture' => $path]);
        }

        // Update or Create extended Profile details
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'bio' => $request->bio,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
            ]
        );

        session()->forget(['welcome', 'error', 'status']);
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    /**
     * Execute the updatePassword action.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
