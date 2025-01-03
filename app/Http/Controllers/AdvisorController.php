<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Appointment;
use App\Models\Student;
use App\Models\StudentCourseSchedule;
use App\Models\AcademicResult;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{

    public function studentList(Request $request)
    {
        $years = range(1, 4);

        $students = User::role('student')
            ->with(['student', 'appointments' => function ($query) {                
                $query->latest();
            }])
            ->when($request->filled('year'), function ($query) use ($request) {
                $query->whereHas('student', function ($query) use ($request) {
                    $query->where('year', $request->year);
                });
            })
            ->get();

        return view('advisor.student-list', compact('students', 'years'));
    }

    public function viewStudentProfile(User $student)
    {
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

       $semesterSchedules = $this->organizeSchedule($student);

       return view('advisor.student-schedule', compact('student', 'semesterSchedules'));
   }

   private function organizeSchedule($student)
   {
       $semesterSchedules = [];

       foreach ($student->student->courseSchedules as $schedule) {
           $semesterSchedules[$schedule->semester_id][] = $schedule;
       }

       return $semesterSchedules;
   }

   public function viewStudentAcademicResult($studentId)
   {
       $student = Student::findOrFail($studentId);

       $semesterSchedules = StudentCourseSchedule::with(['course', 'academicResults'])
           ->where('student_id', $studentId)
           ->get()
           ->groupBy('semester_id');

        $academicResults = AcademicResult::where('student_id', $studentId)
           ->get()
           ->keyBy(function ($item) {
               return $item->course_code . '-' . $item->semester_id;
        });
       return view('advisor.student-academic-result', compact('semesterSchedules', 'student', 'academicResults'));
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

        return collect($semesterSchedules);
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
