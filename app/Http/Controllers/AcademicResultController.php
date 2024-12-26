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

    // Return the view with the filtered data
    return view('academic-result.index', compact('semesterSchedules', 'studentId'));
}


    public function store(Request $request, $studentId)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|string|in:A,A-,B+,B,B-,C+,C,D,D-,E,F',
        ]);

        // Loop through each grade and store or update academic results
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

        // After storing or updating grades, calculate the GPA
        $this->calculateGPA($studentId);

        return redirect()->route('academic-result.index', $studentId)
            ->with('success', 'Academic results have been updated successfully!');
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
        $semesterSchedules = // Retrieve semester schedules for the student
        $cgpa = 0; // Default or computed value
        $totalCreditHours = 0;
        $totalGradePoints = 0;
    
        foreach ($semesterSchedules as $semSchedules) {
            foreach ($semSchedules as $schedule) {
                $creditHour = $schedule->course->credit_hour;
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
    
        return view('academic_results.edit', compact('semesterSchedules', 'cgpa', 'studentId'));
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
        // Validate the incoming request data (e.g., grades and points)
        $request->validate([
            'grades.*' => 'required|in:A,A-,B+,B,B-,C+,C,C-,D-,E,F',  // Validating grade options
            'points.*' => 'required|numeric|min:0|max:4.00',          // Validating points between 0 and 4
        ]);
    
        // Fetch the student's course schedule and academic results
        $studentSchedule = StudentCourseSchedule::with('academicResults')
            ->where('student_id', $studentId)
            ->get();
    
        // Update the academic results for each course
        foreach ($studentSchedule as $schedule) {
            $courseCode = $schedule->course_code;
    
            // Ensure that the course code is a string before using it as an array index
            if (is_string($courseCode)) {
                // If a grade is provided, update the academic result
                if ($request->has("grades.$courseCode") && $request->has("points.$courseCode")) {
                    $grade = $request->input("grades.$courseCode");
                    $point = $request->input("points.$courseCode");
    
                    // Find or create the academic result for this course
                    $academicResult = $schedule->academicResults()->first() ?? new AcademicResult;
                    $academicResult->grade = $grade;
                    $academicResult->point = $point;
                    $academicResult->student_id = $studentId;
                    $academicResult->course_code = $courseCode;
    
                    // Save the academic result
                    $academicResult->save();
                }
            } else {
                // Handle the case where courseCode is not a string (if needed)
                // For example, log an error or skip this iteration
                Log::error("Invalid course code: " . var_export($courseCode, true));
            }
        }
    
        // Redirect back with a success message
        return redirect()->route('academic-result.edit', $studentId)
            ->with('success', 'Academic results updated successfully');
    }
    
    
}
