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
        $academicYears = AcademicYear::all();

        $students = User::role('student')
            ->with(['student', 'appointments' => function ($query) {
                $query->latest();
            }])
            ->whereHas('student', function ($query) use ($request) {
                if ($request->has('academic_year')) {
                    $query->where('academic_year_id', $request->academic_year); // Filter by academic year
                }
            })
            ->get();

        return view('advisor.student-list', compact('students', 'academicYears'));
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
       if (!$student->hasRole('student')) {
           abort(403, 'Unauthorized action.');
       }
   
       // Load courses, semesters, and courseSchedules for the student
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
   

}
