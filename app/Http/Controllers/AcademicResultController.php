<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;

class AcademicResultController extends Controller
{
    public function index($studentId)
    {
        // Fetch academic results for the student
        $academicResults = AcademicResult::where('student_id', $studentId)->get();

        // Return the view with the results
        return view('academic-result.index', compact('academicResults'));
    }

    // Store the academic results in the database
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'course_code' => 'required',
            'grade' => 'required|in:A,B,C,D,Pass,Fail',
            'gpa' => 'required|numeric|between:0,4',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        // Create and save the academic result
        AcademicResult::create([
            'student_id' => auth()->user()->id,  // Assuming the student is logged in
            'course_code' => $request->course_code,
            'grade' => $request->grade,
            'gpa' => $request->gpa,
            'semester_id' => $request->semester_id,
        ]);

        // Redirect back with success message
        return redirect()->route('academic-result.index')->with('success', 'Academic result added successfully!');
    }
}
