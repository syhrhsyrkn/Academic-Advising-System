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
        // Fetch the student's course schedule and eager load related course and semester data
        $studentSchedule = StudentCourseSchedule::with('course', 'semester', 'academicResults')
            ->where('student_id', $studentId)
            ->get();

        // Group the courses by semester
        $semesterSchedules = $studentSchedule->groupBy(function ($schedule) {
            return $schedule->semester_id;
        });

        $isEditing = request()->query('edit') === 'true';

        // Return the view with the student's schedule, semester schedules, and editing flag
        return view('academic-result.index', compact('studentSchedule', 'semesterSchedules', 'studentId', 'isEditing'));
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
                $point = AcademicResult::getGradePoint($grade);

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
        $studentSchedule = StudentCourseSchedule::with(['course', 'semester', 'academicResults'])
            ->where('student_id', $studentId)
            ->get();

        // Group schedules by semester
        $semesterSchedules = $studentSchedule->groupBy('semester_id');

        foreach ($semesterSchedules as $semesterId => $schedules) {
            $totalCredit = 0;
            $totalGradePoint = 0;

            foreach ($schedules as $schedule) {
                $academicResult = $schedule->academicResults->first();

                if ($academicResult) {
                    $creditHour = $schedule->course->credit_hour ?? 0;
                    $gradePoint = $academicResult->point ?? 0;

                    $totalCredit += $creditHour;
                    $totalGradePoint += $creditHour * $gradePoint;
                }
            }

            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;

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


}
