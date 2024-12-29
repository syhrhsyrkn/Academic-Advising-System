<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Appointment;
use App\Models\Student;
use App\Models\StudentCourseSchedule;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{

    public function studentList(Request $request)
    {
        $years = range(1, 4);

        // Fetch students with optional filtering by year
        $students = User::role('student')
            ->with(['student', 'appointments' => function ($query) {
                $query->latest();
            }])
            ->when($request->filled('year'), function ($query) use ($request) {
                // Apply filter only if the year is provided and not empty
                $query->whereHas('student', function ($query) use ($request) {
                    $query->where('year', $request->year);
                });
            })
            ->get();

        return view('advisor.student-list', compact('students', 'years'));
    }

    public function viewStudentProfile(User $student)
    {
        if (!$student->hasRole('student')) {
            abort(403, 'Unauthorized action.');
        }
    
        $studentDetails = $student->student;
        $academicResults = $studentDetails ? $studentDetails->academicResults : []; 
    
        return view('advisor.student-profile', [
            'student' => $student,
            'studentDetails' => $studentDetails,
            'academicResults' => $academicResults,
        ]);
    }

   public function viewStudentSchedule(User $student)
   {

        $student->load('student.courseSchedules.course', 'student.courseSchedules.semester');
   
       // Organize the schedule by semester
       $semesterSchedules = $this->organizeSchedule($student);
   
       return view('advisor.student-schedule', compact('student', 'semesterSchedules'));
   }
   
   private function organizeSchedule($student)
   {
       $semesterSchedules = [];
   
       // Loop through the student's schedules and organize by semester_id
       foreach ($student->student->courseSchedules as $schedule) {
           // Ensure that we only add to an existing semester
           $semesterSchedules[$schedule->semester_id][] = $schedule;
       }
   
       return $semesterSchedules;
   }
   
   public function viewStudentAcademicResult(User $student)
    {

        $student->load('student.courseSchedules.course', 'student.courseSchedules.semester', 'student.courseSchedules.academicResults');

        // Organize the academic results by semester
        $semesterSchedules = $this->organizeAcademicResults($student);
   
        return view('advisor.student-academic-result', compact('student', 'semesterSchedules'));
    }

    private function organizeAcademicResults($student)
    {
        $semesterSchedules = [];

        foreach ($student->student->courseSchedules as $schedule) {
            $semesterId = $schedule->semester_id;
            $academicResult = $schedule->academicResults;

            if ($academicResult) {
                $semesterSchedules[$semesterId][] = [
                    'course' => $schedule->course,
                    'academicResult' => $academicResult,
                ];
            }
        }

        return collect($semesterSchedules); // Ensure it's a collection
    }

    private function getSemesterSchedules(Student $student)
    {
        return $student->courseSchedules()
            ->with(['course', 'academicResults']) 
            ->where('student_id', $student->id) 
            ->get()
            ->groupBy('semester_id');
    }

}
