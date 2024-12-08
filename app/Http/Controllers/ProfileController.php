<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
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
    $user = auth()->user();

    $validated = $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contact_number' => 'required|string|max:15',
        'kulliyyah' => 'required|string|max:255',
        'department' => 'required|string|max:255',
    ]);

    if ($user->hasRole('student')) {
        $validated['matric_no'] = $request->input('matric_no');
        $validated['specialisation'] = $request->input('specialisation');
        $validated['year'] = $request->input('year');
        $validated['semester'] = $request->input('semester');
    }

    $user->profile->update($validated);

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
}
}
