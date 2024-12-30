<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Staff;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if ($user->hasRole('student')) {
            $profile = Student::where('user_id', $user->id)->first();
        } else {
            $profile = Staff::where('user_id', $user->id)->first();
        }

        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->merge([
            'semester' => (int) $request->input('semester'),
            'year' => (int) $request->input('year'),
        ]);

        
        $rules = [
            'full_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'kulliyyah' => 'required|string|max:255',
            'department' => 'required|in:Department of Information Systems,Department of Computer Science', 
        ];

        if ($user->hasRole('student')) {
            $rules['matric_no'] = 'required|string|max:50';
            $rules['specialisation'] ='required|in:Cybersecurity,Cloud Computing and System Paradigm,Innovative Digital Experience (IDEx),Data Analytics,Digital Transformation,-';
            $rules['semester'] = 'required|integer|min:1|max:3';
            $rules['year'] = 'required|integer|min:1|max:4';
        } else {
            $rules['staff_id'] = 'required|string|max:50';
        }

        $data = $request->validate($rules);

        if ($user->hasRole('student')) {
            $student = Student::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $data['full_name'],
                    'contact_no' => $data['contact_no'],
                    'matric_no' => $data['matric_no'],
                    'kulliyyah' => $data['kulliyyah'],
                    'department' => $data['department'],
                    'specialisation' => $data['specialisation'],
                    'semester' => $data['semester'], 
                    'year' => $data['year'], 
                ]
            );
        } else {
            $staff = Staff::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $data['full_name'],
                    'contact_no' => $data['contact_no'],
                    'staff_id' => $data['staff_id'],
                    'kulliyyah' => $data['kulliyyah'],
                    'department' => $data['department'],
                ]
            );
        }

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function show()
    {
        $user = Auth::user()->load('roles');
        $profile = null;
        $semesterInfo = null;
    
        if ($user->hasRole('student')) {
            $profile = Student::where('user_id', $user->id)->first();
            
            $semesterInfo = [
                'semester' => $profile->semester ?? null,
                'year' => $profile->year ?? null,
            ];
            
        } elseif ($user->hasRole(['admin', 'advisor'])) {
            $profile = Staff::where('user_id', $user->id)->first();
        }
    
        if (!$profile) {
            return redirect()->back()->with('error', 'Profile not found.');
        }
    
        return view('profile.show', compact('profile', 'semesterInfo'));
    }
}
