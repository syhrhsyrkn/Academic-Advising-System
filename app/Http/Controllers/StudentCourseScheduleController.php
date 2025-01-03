<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentCourseSchedule;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentCourseScheduleController extends Controller
{
    public function index($studentId)
    {   
        $student = Student::findOrFail($studentId);

        $semesters = Semester::all();
        $courses = Course::all();

        $semesterSchedules = [];
        foreach ($semesters as $semester) {
            $semesterSchedules[$semester->id] = StudentCourseSchedule::where('student_id', $studentId)
                ->where('semester_id', $semester->id)
                ->with('course') 
                ->get();
        }

        $existingCourses = StudentCourseSchedule::where('student_id', $studentId)
            ->pluck('course_code')
            ->toArray();

        return view('student-course-schedule.index', compact(
            'semesterSchedules', 'semesters', 'courses', 'studentId', 'existingCourses'
        ));
    }


    public function store(Request $request, $studentId)
    {
        $request->validate([
            'course_code' => 'required|exists:courses,course_code',
            'semester_id' => 'required|exists:semesters,id',
        ]);
    
        $existingCourse = StudentCourseSchedule::where('student_id', $studentId)
            ->where('course_code', $request->course_code)
            ->where('semester_id', '<>', $request->semester_id) // Ensure it's not the same semester
            ->exists();
    
        if ($existingCourse) {
            return redirect()->back()->withErrors(['course_code' => 'You have already added this course to another semester.']);
        }
    
        $course = Course::where('course_code', $request->course_code)->first();
    
        if (!$course) {
            return redirect()->back()->withErrors([
                'course_code' => 'The selected course does not exist.'
            ]);
        }
    
        $semesterId = $request->semester_id;
        $totalCreditHours = StudentCourseSchedule::where('student_id', $studentId)
            ->where('semester_id', $semesterId)
            ->join('courses', 'student_course_schedule.course_code', '=', 'courses.course_code')
            ->sum('courses.credit_hour');
    
        $newTotalCreditHours = $totalCreditHours + $course->credit_hour;
    
        if ($newTotalCreditHours > 20) {
            return redirect()->back()->withErrors(['course_code' => 'Adding this course exceeds the maximum credit hour limit of 20 for the semester.']);
        }
    
        $prerequisites = DB::table('prerequisites')
            ->where('course_code', $request->course_code)
            ->get();
    
        foreach ($prerequisites as $prerequisite) {
            $currentSemesterId = $request->semester_id;
            $currentSemester = Semester::findOrFail($currentSemesterId);
            $currentAcademicYearId = $currentSemester->academic_year_id;
    
            $hasTakenPrerequisite = StudentCourseSchedule::where('student_id', $studentId)
                ->where('course_code', $prerequisite->prerequisite_code)
                ->whereHas('semester', function ($query) use ($currentAcademicYearId, $currentSemesterId) {
                    $query->where('academic_year_id', '<=', $currentAcademicYearId)
                        ->where('semester_id', '<', $currentSemesterId); // Make sure it's before the current semester
                })
                ->exists();
    
            if (!$hasTakenPrerequisite) {
                return redirect()->back()->withErrors([
                    'course_code' => 'You must complete the prerequisite course (' . $prerequisite->prerequisite_code . ') before adding this course.'
                ]);
            }
        }
    
        $existingEnrollment = StudentCourseSchedule::where('student_id', $studentId)
            ->where('course_code', $request->course_code)
            ->where('semester_id', $request->semester_id)
            ->exists();
    
        if ($existingEnrollment) {
            return redirect()->back()->withErrors([
                'course_code' => 'You are already enrolled in this course for the selected semester.'
            ]);
        }
    
        try {
            StudentCourseSchedule::create([
                'student_id' => $studentId,
                'course_code' => $request->course_code,
                'semester_id' => $request->semester_id,
            ]);
    
            return redirect()->route('student_course_schedule.index', $studentId)
                ->with('success', 'Course added to schedule successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'course_code' => 'An error occurred while adding the course. Please try again.'
            ]);
        }
    }
    
    public function destroy($studentId, $courseCode, $semesterId)
    {
        StudentCourseSchedule::where('student_id', $studentId)
            ->where('course_code', $courseCode)
            ->where('semester_id', $semesterId)
            ->delete();

        return redirect()->route('student_course_schedule.index', $studentId)
            ->with('success', 'Course removed from schedule successfully.');
    }
}
