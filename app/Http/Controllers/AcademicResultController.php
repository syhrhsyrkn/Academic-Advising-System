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
        $studentSchedule = StudentCourseSchedule::with('course')
            ->where('student_id', $studentId)
            ->get();

        $semesterSchedules = $studentSchedule->groupBy('semester_id');

        $gpas = [];
        $cumulativeCredit = 0;
        $cumulativeGradePoint = 0;

        $academicResults = AcademicResult::where('student_id', $studentId)
            ->get()
            ->keyBy(function ($item) {
                return $item->course_code . '-' . $item->semester_id; 
            });

        foreach ($semesterSchedules as $semesterId => $schedules) {
            $totalCredit = 0;
            $totalGradePoint = 0;

            foreach ($schedules as $schedule) {
                $academicResultKey = $schedule->course_code . '-' . $semesterId;
                $academicResult = $academicResults->get($academicResultKey);

                $gradePoint = $academicResult ? $academicResult->point : 0;

                $creditHour = $schedule->course->credit_hour ?? 0;
                $totalCredit += $creditHour;
                $totalGradePoint += $creditHour * $gradePoint;
            }

            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
            $gpas[$semesterId] = $gpa;

            $cumulativeCredit += $totalCredit;
            $cumulativeGradePoint += $totalGradePoint;
        }

        $cgpa = $cumulativeCredit > 0 ? round($cumulativeGradePoint / $cumulativeCredit, 2) : 0;

        return view('academic-result.index', compact('semesterSchedules', 'studentId', 'gpas', 'cgpa', 'academicResults'));
    }

    private function calculateSemesterGPA($schedules)
    {
        $totalCredit = 0;
        $totalGradePoint = 0;

        foreach ($schedules as $schedule) {
            $academicResult = $schedule->academicResults;  

            if ($academicResult) {
                $creditHour = $schedule->course->credit_hour ?? 0;
                $gradePoint = $academicResult->point ?? 0;

                $totalCredit += $creditHour;
                $totalGradePoint += $creditHour * $gradePoint;
            }
        }

        return $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
    }

    public function calculateGPA($studentId)
    {
        $studentSchedule = StudentCourseSchedule::with(['course', 'academicResults'])
            ->where('student_id', $studentId)
            ->get();

        $semesterSchedules = $studentSchedule->groupBy('semester_id');

        foreach ($semesterSchedules as $semesterId => $schedules) {
            $gpa = $this->calculateSemesterGPA($schedules);

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

            $totalCreditForSemester = 0;
            $totalGradePointForSemester = 0;

            foreach ($semesterSchedule as $schedule) {
                $creditHour = $schedule->course->credit_hour ?? 0;
                $totalCreditForSemester += $creditHour;
            }

            $totalCredits += $totalCreditForSemester;
            $totalGradePoints += ($totalCreditForSemester * $semesterGpa->gpa); 
        }

        $cgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

        return $cgpa;
    }

    public function edit($studentId, Request $request)
    {
        // Get semester schedules grouped by semester
        $semesterSchedules = StudentCourseSchedule::with(['course', 'academicResults'])
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('semester_id');
    
        // Initialize variables for CGPA calculation
        $cgpa = 0;
        $totalCreditHours = 0;
        $totalGradePoints = 0;
    
        // Get academic results for the student, indexed by course_code and semester_id
        $academicResults = AcademicResult::where('student_id', $studentId)
            ->get()
            ->keyBy(function ($item) {
                return $item->course_code . '-' . $item->semester_id;
            });
    
        // Dynamically get semester_id from request or default to 1
        $semesterId = $request->input('semester_id', 1); // Ensure semester_id is passed in the request
    
        // Check if semester_id is valid and exists in the schedules
        if (!isset($semesterSchedules[$semesterId])) {
            // If the requested semester_id does not exist, default to the first semester
            $semesterId = $semesterSchedules->keys()->first();
        }
    
        // Iterate over the schedules grouped by semester_id
        foreach ($semesterSchedules as $semSchedules) {
            foreach ($semSchedules as $schedule) {
                $creditHour = $schedule->course->credit_hour ?? 0;
    
                // Check if academicResults exists and is not null
                if ($schedule->academicResults) {
                    // Find the academic result for the current semester
                    $academicResult = $schedule->academicResults->firstWhere('semester_id', $semesterId);
                    $grade = $academicResult ? $academicResult->grade : null;
    
                    if ($grade) {
                        // Assuming you have a method to get grade points
                        $gradePoint = AcademicResult::getGradePoint($grade);
                        $totalCreditHours += $creditHour;
                        $totalGradePoints += $creditHour * $gradePoint;
                    }
                }
            }
        }
    
        // Calculate CGPA if total credit hours is greater than 0
        if ($totalCreditHours > 0) {
            $cgpa = round($totalGradePoints / $totalCreditHours, 2);
        }
    
        // Return the edit view with the necessary data
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
        // Debugging step to check the semester_id value (you can remove this later)
        // dd($request->input('semester_id'));

        // Validate the incoming request
        $validated = $request->validate([
            'grades' => 'required|array',
            'points' => 'required|array',
            'semester_id' => 'required|integer',
        ]);

        // Get the semester_id from the validated request
        $semesterId = $request->input('semester_id'); 

        // Iterate over the grades array
        foreach ($request->input('grades') as $courseCode => $grade) {
            // Get the corresponding grade point for the grade
            $point = AcademicResult::getGradePoint($grade); 

            // Check if an academic result already exists for the given student, course, and semester
            $academicResult = AcademicResult::where('student_id', $studentId)
                ->where('course_code', $courseCode)
                ->where('semester_id', $semesterId)
                ->first();

            if ($academicResult) {
                // If the result exists, update it
                $academicResult->update([
                    'grade' => $grade,
                    'point' => $point,
                ]);
            } else {
                // If the result does not exist, create a new one
                AcademicResult::create([
                    'student_id' => $studentId,
                    'course_code' => $courseCode,
                    'semester_id' => $semesterId, // Use the correct semester_id here
                    'grade' => $grade,
                    'point' => $point,
                ]);
            }
        }

        // Redirect to the academic results page with a success message
        return redirect()->route('academic-result.index', ['studentId' => $studentId])
            ->with('success', 'Results updated successfully.');
    }


}
