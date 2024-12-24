<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\StudentCourseSchedule;
use App\Models\SemesterGpa;
use Illuminate\Http\Request;

class AcademicResultController extends Controller
{
    public function index($studentId)
    {
        // Fetch the student's course schedule and eager load course and academic results
        $studentSchedule = StudentCourseSchedule::with(['course', 'academicResults'])
            ->where('student_id', $studentId)
            ->get();
    
        // If necessary, further filter or modify academic results to ensure they belong to the right student
        $studentSchedule->each(function ($schedule) use ($studentId) {
            $schedule->load(['academicResults' => function ($query) use ($studentId) {
                $query->where('student_id', $studentId);  // Ensure the academic results match the student_id
            }]);
        });
    
        // Group the schedules by semester_id
        $semesterSchedules = $studentSchedule->groupBy('semester_id');
    
        $gpas = [];
        $cumulativeCredit = 0;
        $cumulativeGradePoint = 0;

        foreach ($semesterSchedules as $semesterId => $schedules) {
            $totalCredit = 0;
            $totalGradePoint = 0;

            foreach ($schedules as $schedule) {
                $academicResult = $schedule->academicResults ? $schedule->academicResults->first() : null;
    
                $creditHour = $schedule->course->credit_hour ?? 0;
                $gradePoint = $academicResult ? $academicResult->point : 0;
    
                $totalCredit += $creditHour;
                $totalGradePoint += $creditHour * $gradePoint;
            }
    
            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
            $gpas[$semesterId] = $gpa;
    
            // Cumulative GPA
            $cumulativeCredit += $totalCredit;
            $cumulativeGradePoint += $totalGradePoint;
        }
    
        $cgpa = $cumulativeCredit > 0 ? round($cumulativeGradePoint / $cumulativeCredit, 2) : 0;
    
        // Return the view with the filtered data
        return view('academic-result.index', compact('semesterSchedules', 'studentId', 'gpas', 'cgpa'));

    }
    
    public function store(Request $request, $studentId)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|string|in:A,A-,B+,B,B-,C+,C,D,D-,E,F',
        ]);

        foreach ($request->grades as $courseCode => $grade) {
            $schedule = StudentCourseSchedule::where('student_id', $studentId)
                ->where('course_code', $courseCode)
                ->first();

            if ($schedule) {
                $point = AcademicResult::getGradePoint($grade);  // Use the method here

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

        $this->calculateGPA($studentId);

        return redirect()->route('academic-result.index', $studentId)
            ->with('success', 'Academic results have been updated successfully!');
    }

    public function calculateGPA($studentId)
    {
        // Fetch the student's course schedule along with related data
        $studentSchedule = StudentCourseSchedule::with(['course', 'academicResults'])
            ->where('student_id', $studentId)
            ->get();

        // Group schedules by semester
        $semesterSchedules = $studentSchedule->groupBy('semester_id');

        // Loop through each semester to calculate GPA
        foreach ($semesterSchedules as $semesterId => $schedules) {
            $totalCredit = 0;
            $totalGradePoint = 0;

            foreach ($schedules as $schedule) {
                $academicResult = $schedule->academicResults ? $schedule->academicResults->first() : null;

                if ($academicResult) {
                    $creditHour = $schedule->course->credit_hour ?? 0;
                    $gradePoint = $academicResult->point ?? 0;

                    // Accumulate total credits and grade points
                    $totalCredit += $creditHour;
                    $totalGradePoint += $creditHour * $gradePoint;
                }
            }

            // Calculate GPA for the semester
            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;

            // Store or update the GPA for the semester
            SemesterGpa::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'semester_id' => $semesterId,
                ],
                [
                    'gpa' => $gpa,
                ]
            );
        }
    }

    public function calculateCGPA($studentId)
    {
        $semesterGpas = SemesterGpa::where('student_id', $studentId)->get();
        $totalCredits = 0;
        $totalGradePoints = 0;

        foreach ($semesterGpas as $semesterGpa) {
            $semesterSchedule = StudentCourseSchedule::where('student_id', $studentId)
                ->where('semester_id', $semesterGpa->semester_id)
                ->get();

            foreach ($semesterSchedule as $schedule) {
                $creditHour = $schedule->course->credit_hour ?? 0;
                $gradePoint = $semesterGpa->gpa ?? 0;

                $totalCredits += $creditHour;
                $totalGradePoints += $creditHour * $gradePoint;
            }
        }

        $cgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

        // Optionally store the CGPA in a separate table or update the student model
        return $cgpa;
    }



    public function edit($studentId)
    {
        // Fetch the student's course schedule and eager load related course and semester data
        $studentSchedule = StudentCourseSchedule::with('course', 'semester', 'academicResults')
            ->where('student_id', $studentId)
            ->get();

        // Group the courses by semester
        $semesterSchedules = $studentSchedule->groupBy(function ($schedule) {
            return $schedule->semester_id;
        });

        // Return the edit view
        return view('academic-result.edit', compact('studentSchedule', 'semesterSchedules', 'studentId'));
    }

    public function update(Request $request, $studentId)
{
    // Validate the input grades
    $request->validate([
        'grades' => 'required|array',
        'grades.*' => 'required|string|in:A,A-,B+,B,B-,C+,C,D,D-,E,F',
    ]);

    foreach ($request->grades as $courseCode => $grade) {
        $schedule = StudentCourseSchedule::where('student_id', $studentId)
            ->where('course_code', $courseCode)
            ->first();

        if ($schedule) {
            // Get the grade point from the grade
            $point = AcademicResult::getGradePoint($grade);

            // Update or create the academic result for this course
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

    // Recalculate GPA after updating academic results
    $this->calculateGPA($studentId);

    return redirect()->route('academic-result.index', $studentId)
        ->with('success', 'Academic results have been updated successfully!');
}

}
