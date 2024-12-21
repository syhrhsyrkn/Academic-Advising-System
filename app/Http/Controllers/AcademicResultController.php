<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentCourseSchedule;
use Illuminate\Http\Request;

class AcademicResultController extends Controller
{
    public function index($studentId)
    {
        // Fetch the student's course schedule and eager load the related course data
        $studentSchedule = StudentCourseSchedule::with('course', 'semester') // Eager load the 'course' and 'semester' relationships
            ->where('student_id', $studentId) // Ensure you're fetching for the correct student
            ->get();

        // Group courses by semester
        $semesterSchedules = $studentSchedule->groupBy(function ($schedule) {
            return $schedule->semester_id; // Group by semester_id
        });

        // Check if the student is editing or just viewing
        $isEditing = request()->query('edit') === 'true';

        // Return the view with the student's schedule and semesterSchedules
        return view('academic-result.index', compact('studentSchedule', 'semesterSchedules', 'studentId', 'isEditing'));
    }

    public function store(Request $request, $studentId)
    {
        $request->validate([
            'grades' => 'required|array',
            'scores' => 'required|array',
            'grades.*' => 'required|string|in:A,B,C,D,Pass,Fail', // Grade validation
            'scores.*' => 'required|numeric|between:0,4', // Score validation
        ]);

        // Loop through each course and store the grade and score
        foreach ($request->grades as $index => $grade) {
            $score = $request->scores[$index];
            $courseCode = $request->course_code[$index];
            $semesterId = $request->semester_id[$index];

            // Create or update the academic result
            AcademicResult::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'course_code' => $courseCode,
                    'semester_id' => $semesterId,
                ],
                [
                    'grade' => $grade,
                    'score' => $score,
                ]
            );
        }

        // Redirect back to the academic results page with a success message
        return redirect()->route('academic-result.index', $studentId)
            ->with('success', 'Academic results have been updated successfully!');
    }
}
