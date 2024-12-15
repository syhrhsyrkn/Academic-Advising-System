<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentCourseSchedule;
use App\Models\Course;
use App\Models\Semester;
use App\Models\Student;

class StudentCourseScheduleController extends Controller
{
    public function index($studentId)
    {
        $student = Student::findOrFail($studentId);
        $schedules = StudentCourseSchedule::where('student_id', $studentId)
        ->with(['course', 'semester', 'semester.academicYear']) // Eager load semester and its related academic year
        ->get();


        $semesters = Semester::all();
        $courses = Course::all();

        return view('student-course-schedule.index', compact('schedules', 'semesters', 'courses', 'studentId'));
    }

    public function store(Request $request, $studentId)
    {
        // Validate request data
        $request->validate([
            'course_code' => 'required|exists:courses,course_code',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        // Get the course based on the course code
        $course = Course::where('course_code', $request->course_code)->first();

        // Check if the course has prerequisites
        if ($course->prerequisite_course_code) {
            $hasTakenPrerequisite = StudentCourseSchedule::where('student_id', $studentId)
                ->where('course_code', $course->prerequisite_course_code)
                ->exists();

            // If prerequisite not completed, show error
            if (!$hasTakenPrerequisite) {
                return redirect()->back()->withErrors([
                    'course_code' => 'You must complete the prerequisite course (' . $course->prerequisite_course_code . ') before adding this course.'
                ]);
            }
        }

        // Add course to the student's schedule
        StudentCourseSchedule::create([
            'student_id' => $studentId,
            'course_code' => $request->course_code,
            'semester_id' => $request->semester_id,
        ]);

        // Redirect back to the course schedule view
        return redirect()->route('student_course_schedule.index', $studentId)
            ->with('success', 'Course added to schedule successfully.');
    }

    public function destroy($studentId, $courseCode, $semesterId)
    {
        // Remove the course from the schedule
        StudentCourseSchedule::where('student_id', $studentId)
            ->where('course_code', $courseCode)
            ->where('semester_id', $semesterId)
            ->delete();

        // Redirect back to the course schedule view
        return redirect()->route('student_course_schedule.index', $studentId)
            ->with('success', 'Course removed from schedule successfully.');
    }
}
