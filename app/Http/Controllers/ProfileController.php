<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show profile edit modal or page
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user')); // Optional if you're using a full profile page
    }

    // Update profile
    public function update(Request $request)
    {
        $user = Auth::user();
        // dd($request->all()); // Debugging line to check the request data

        $request->validate([
            // 'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile' => 'nullable|image|max:2048',
        ]);

        // $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile')) {
            // Delete old profile image if exists
            if ($user->profile && Storage::exists($user->profile)) {
                Storage::delete($user->profile);
            }

            // Store new image
            $path = $request->file('profile')->store('profiles', 'public');
            $user->profile = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}