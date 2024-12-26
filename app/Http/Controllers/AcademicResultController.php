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
        // Eager load both 'course' and 'academicResults' relationships
        $studentSchedule = StudentCourseSchedule::with('course')
            ->where('student_id', $studentId)
            ->get();

        // Group the schedules by semester_id
        $semesterSchedules = $studentSchedule->groupBy('semester_id');

        // Calculate GPA and CGPA for each semester
        $gpas = [];
        $cumulativeCredit = 0;
        $cumulativeGradePoint = 0;

        // Retrieve all academicResults for the student at once for easy access
        $academicResults = AcademicResult::where('student_id', $studentId)
            ->get()
            ->keyBy(function ($item) {
                return $item->course_code . '-' . $item->semester_id; // Combine course_code and semester_id as the key
            });

        foreach ($semesterSchedules as $semesterId => $schedules) {
            $totalCredit = 0;
            $totalGradePoint = 0;

            foreach ($schedules as $schedule) {
                // Get academicResult based on course_code and semester_id
                $academicResultKey = $schedule->course_code . '-' . $semesterId;
                $academicResult = $academicResults->get($academicResultKey);

                // Get gradePoint or set to 0 if not available
                $gradePoint = $academicResult ? $academicResult->point : 0;

                // Get credit hour and accumulate totals
                $creditHour = $schedule->course->credit_hour ?? 0;
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

        // Return the view with the calculated data, including the academicResults relationship
        return view('academic-result.index', compact('semesterSchedules', 'studentId', 'gpas', 'cgpa', 'academicResults'));
    }

    // Helper function to calculate the GPA for a given semester
    private function calculateSemesterGPA($schedules)
    {
        $totalCredit = 0;
        $totalGradePoint = 0;

        foreach ($schedules as $schedule) {
            // Fetch the single academic result for this schedule (one result per course)
            $academicResult = $schedule->academicResults;  // This will now be a single result

            if ($academicResult) {
                $creditHour = $schedule->course->credit_hour ?? 0;
                $gradePoint = $academicResult->point ?? 0;

                // Accumulate total credits and grade points
                $totalCredit += $creditHour;
                $totalGradePoint += $creditHour * $gradePoint;
            }
        }

        // Calculate GPA for the semester
        return $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
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
            $gpa = $this->calculateSemesterGPA($schedules);

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
            // Fetch the courses for each semester and calculate the total credits and grade points
            $semesterSchedule = StudentCourseSchedule::where('student_id', $studentId)
                ->where('semester_id', $semesterGpa->semester_id)
                ->get();

            $totalCreditForSemester = 0;
            $totalGradePointForSemester = 0;

            foreach ($semesterSchedule as $schedule) {
                $creditHour = $schedule->course->credit_hour ?? 0;
                $totalCreditForSemester += $creditHour;
            }

            $totalCredits += $totalCreditForSemester;
            $totalGradePoints += ($totalCreditForSemester * $semesterGpa->gpa); // Multiply credits by the GPA of the semester
        }

        // Calculate the CGPA
        $cgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

        // Optionally store the CGPA in a separate table or update the student model
        return $cgpa;
    }

    public function edit($studentId)
    {
        $semesterSchedules = StudentCourseSchedule::with(['course', 'academicResults'])
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('semester_id');

        $cgpa = 0; // Default value for CGPA
        $totalCreditHours = 0;
        $totalGradePoints = 0;

        $academicResults = AcademicResult::where('student_id', $studentId)
        ->get()
        ->keyBy(function ($item) {
            return $item->course_code . '-' . $item->semester_id; // Combine course_code and semester_id as the key
        });

        // Define $semesterId (you can get it dynamically depending on your use case)
        // For example, if you want the current semester, you can set it dynamically:
        $semesterId = 1; // or retrieve from the database or user input

        foreach ($semesterSchedules as $semSchedules) {
            foreach ($semSchedules as $schedule) {
                $creditHour = $schedule->course->credit_hour ?? 0;
                $grade = $schedule->academicResults->grade ?? null;

                if ($grade) {
                    $gradePoint = AcademicResult::getGradePoint($grade);
                    $totalCreditHours += $creditHour;
                    $totalGradePoints += $creditHour * $gradePoint;
                }
            }
        }

        if ($totalCreditHours > 0) {
            $cgpa = round($totalGradePoints / $totalCreditHours, 2);
        }

        return view('academic-result.edit', compact('semesterSchedules', 'cgpa', 'studentId', 'semesterId', 'academicResults'));
    }



    public function getGradePoint($grade)
    {
        $gradePoints = [
            'A' => 4.00,
            'A-' => 3.67,
            'B+' => 3.33,
            'B' => 3.00,
            'B-' => 2.67,
            'C+' => 2.33,
            'C' => 2.00,
            'D' => 1.67,
            'D-' => 1.33,
            'E' => 1.00,
            'F' => 0.00,
        ];

        return $gradePoints[$grade] ?? 0;
    }
    public function update(Request $request, $studentId)
{

    $validated = $request->validate([
        'grades' => 'required|array',
        'points' => 'required|array',
        'semester_id' => 'required|integer',
    ]);

    // Iterate over each course and save grade and points
    foreach ($request->grades as $courseCode => $grade) {
        $point = AcademicResult::getGradePoint($grade); // Convert grade to point
        $academicResult = AcademicResult::where('student_id', $studentId)
            ->where('course_code', $courseCode)
            ->where('semester_id', $request->semester_id)
            ->first();

            if ($academicResult) {
                AcademicResult::where('student_id', $studentId)
                    ->where('course_code', $courseCode)
                    ->where('semester_id', $request->semester_id)
                    ->update([
                        'grade' => $grade,
                        'point' =>  $point,
                    ]);
            }
        else {
            // Insert new academic result if not already present
            AcademicResult::create([
                'student_id' => $studentId,
                'course_code' => $courseCode,
                'semester_id' => $request->semester_id,
                'grade' => $grade,
                'point' => $point,
            ]);
        }
    }

    return redirect()->route('academic-result.index', ['studentId' => $studentId])
                     ->with('success', 'Results updated successfully.');
}

}
