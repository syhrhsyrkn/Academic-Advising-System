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
        $user = Auth::user();

        // Validation based on role
        if ($user->hasRole('student')) {
            $request->validate([
                'full_name' => 'required|string',
                'contact_number' => 'required|string',
                'kulliyyah' => 'required|string',
                'department' => 'required|string',
                'matric_no' => 'required|string',
                'specialisation' => 'nullable|string',
                'year' => 'nullable|integer',
                'semester' => 'nullable|integer',
            ]);
        } elseif ($user->hasRole(['advisor', 'admin'])) {
            $request->validate([
                'full_name' => 'required|string',
                'contact_number' => 'required|string',
                'kulliyyah' => 'required|string',
                'department' => 'required|string',
                'staff_id' => 'required|string',
            ]);
        }

        $profile = $user->profile;

        $profile->update($request->only([
            'full_name',
            'contact_number',
            'kulliyyah',
            'department',
            'matric_no',
            'specialisation',
            'year',
            'semester',
            'staff_id',
        ]));

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
