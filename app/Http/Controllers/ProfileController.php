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

        $rules = [
            'full_name' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'kulliyyah' => 'required|string|max:255',
            'department' => 'required|in:Department of Information Systems,Department of Computer Science', // Validation rule for dropdown
        ];

        if ($user->hasRole('student')) {
            $rules['matric_no'] = 'required|string|max:50';
            $rules['specialisation'] = 'nullable|string|max:255';
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
            // Fetch student data from the 'students' table
            $profile = Student::where('user_id', $user->id)->first();
            
            // Retrieve the latest academic year and semester based on the student's course schedule
            $semesterInfo = DB::table('student_course_schedule')
                ->join('semesters', 'student_course_schedule.semester_id', '=', 'semesters.id')
                ->join('academic_years', 'semesters.academic_year_id', '=', 'academic_years.id')
                ->where('student_course_schedule.student_id', $profile->student_id) // Using student_id from the 'students' table
                ->select('semesters.semester_name', 'academic_years.year_name')
                ->orderByDesc('academic_years.id') // Order by academic year descending
                ->orderByDesc('semesters.id') // Order by semester descending
                ->first();
        } elseif ($user->hasRole(['admin', 'advisor'])) {
            // Fetch staff data from the 'staff' table
            $profile = Staff::where('user_id', $user->id)->first();
        }
    
        if (!$profile) {
            return redirect()->back()->with('error', 'Profile not found.');
        }
    
        return view('profile.show', compact('profile', 'semesterInfo'));
    }
}
