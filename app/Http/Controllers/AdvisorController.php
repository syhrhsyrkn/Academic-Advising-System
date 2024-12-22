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
   
   public function viewStudentAcademicResult(Student $student)
   {
       $semesterSchedules = $this->getSemesterSchedules($student);
   
       return view('advisor.student-academic-result', compact('student', 'semesterSchedules'));
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
