<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\StudentCourseSchedule;
use Illuminate\Http\Request;

class AcademicResultController extends Controller
{
    public function index($studentId)
    {
        // Fetch the student's course schedule and eager load related course and semester data
        $studentSchedule = StudentCourseSchedule::with('course', 'semester', 'academicResults')
        ->where('student_id', $studentId)
            ->get();

        // Group the courses by semester
        $semesterSchedules = $studentSchedule->groupBy(function ($schedule) {
            return $schedule->semester_id;
        });

        // Check if the student is editing or just viewing
        $isEditing = request()->query('edit') === 'true';

        // Return the view with the student's schedule, semester schedules, and editing flag
        return view('academic-result.index', compact('studentSchedule', 'semesterSchedules', 'studentId', 'isEditing'));
    }

    public function store(Request $request, $studentId)
    {
        // Validate the incoming grades and points
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|string|in:A,A-,B+,B,B-,C+,C,D,D-,E,F', // Grade validation
            'points' => 'required|array',
            'points.*' => 'required|numeric|min:0|max:4.00', // Grade point validation
        ]);
    
        // Loop through each course and update or create the academic result
        foreach ($request->grades as $courseCode => $grade) {
            $schedule = StudentCourseSchedule::where('student_id', $studentId)
                ->where('course_code', $courseCode)
                ->first();
    
            if ($schedule) {
                // Get the grade point from the point array or use the default method
                $point = $request->points[$courseCode] ?? AcademicResult::getGradePoint($grade);
    
                // Update or create the academic result
                AcademicResult::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'course_code' => $courseCode,
                        'semester_id' => $schedule->semester_id,
                    ],
                    [
                        'grade' => $grade,
                        'point' => $point,
                    ]
                );
            }
        }
    
        // Redirect back to the academic results page with a success message
        return redirect()->route('academic-result.index', $studentId)
            ->with('success', 'Academic results have been updated successfully!');
    }
    
    public function calculateGPA($studentId)
    {
        // Fetch the student's course schedule and academic results
        $studentSchedule = StudentCourseSchedule::with('course', 'semester')
            ->where('student_id', $studentId)
            ->get();

        // Group the courses by semester
        $semesterSchedules = $studentSchedule->groupBy(function ($schedule) {
            return $schedule->semester_id;
        });

        // Calculate GPA for each semester
        $semesterGPA = [];

        foreach ($semesterSchedules as $semesterId => $schedules) {
            $totalCredit = 0;
            $totalGradePoint = 0;

            foreach ($schedules as $schedule) {
                $academicResult = AcademicResult::where('student_id', $studentId)
                    ->where('course_code', $schedule->course_code)
                    ->where('semester_id', $schedule->semester_id)
                    ->first();

                if ($academicResult) {
                    $totalCredit += $schedule->course->credit_hour;
                    $totalGradePoint += $academicResult->point * $schedule->course->credit_hour;
                }
            }

            // Calculate the GPA for the semester
            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
            $semesterGPA[$semesterId] = $gpa;
        }

        return $semesterGPA;
    }
}
