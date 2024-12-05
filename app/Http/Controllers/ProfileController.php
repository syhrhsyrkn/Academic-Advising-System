<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = Auth::user()->profile;

        return view('profile.profile', compact('profile'));
    }

    public function edit()
    {
        $profile = Auth::user()->profile;

        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
         // Get the currently authenticated user
    $user = auth()->user();

    // Validate the input fields
    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contact_number' => 'required|string|max:15',
        'kulliyyah' => 'required|string|max:255',
        'department' => 'required|string|max:255',
    ]);

    // Handle Student Role Fields
    if ($user->hasRole('student')) {
        $validated['matric_no'] = $request->input('matric_no');
        $validated['specialisation'] = $request->input('specialisation');
        $validated['year'] = $request->input('year');
        $validated['semester'] = $request->input('semester');
    }

    // Update the user's profile (assuming there's a relationship with Profile)
    $user->profile->update($validated);

    // Redirect with success message
    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
}
}
