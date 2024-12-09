<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function show()
    {
        // Fetch the authenticated user and their profile
        $user = Auth::user();
        $profile = $user->profile; // Assuming 'profile' is a relationship on the User model

        return view('profile.profile', compact('profile'));
    }

    public function edit()
    {
        // Fetch the authenticated user and their profile for editing
        $profile = Auth::user()->profile;

        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Validate the request input
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'kulliyyah' => 'required|string|max:255',
            'department' => 'required|string|max:255',
        ]);

        // Add student-specific fields if the user is a student
        if ($user->hasRole('student')) {
            $validated['matric_no'] = $request->input('matric_no');
            $validated['specialisation'] = $request->input('specialisation');
            $validated['year'] = $request->input('year');
            $validated['semester'] = $request->input('semester');
        }

        // Add staff-specific fields if the user is an advisor or admin
        if ($user->hasRole('advisor') || $user->hasRole('admin')) {
            $validated['staff_id'] = $request->input('staff_id');
        }

        // Retrieve the user's profile and update or create it
        $profile = $user->profile;
        
        if ($profile) {
            // Update the existing profile
            $profile->update($validated);
        } else {
            // Create a new profile if it doesn't exist
            $user->profile()->create($validated);
        }

        // Redirect to the profile page with a success message
        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
