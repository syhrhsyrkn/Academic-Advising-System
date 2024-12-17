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
        // Fetch the student by ID
        $student = Student::findOrFail($studentId);

        // Fetch all semesters
        $semesters = Semester::all(); // Retrieve all available semesters

        // Fetch all courses
        $courses = Course::all(); // Retrieve all available courses

        // Get the current academic year and semester for the student (optional if dynamic)
        $currentAcademicYearId = $student->academic_year_id; // Assuming student model has this attribute

        // Fetch the student's course schedule for each semester based on academic year
        $semesterSchedules = [];
        foreach ($semesters as $semester) {
            // Fetch courses for the current semester and academic year
            $semesterSchedules[$semester->id] = StudentCourseSchedule::where('student_id', $studentId)
                ->where('semester_id', $semester->id) // Use the semester id
                ->with('course') // Load related course details like credit_hour
                ->get();
        }

        // Pass the schedules, semesters, and courses to the view
        return view('student-course-schedule.index', compact(
            'semesterSchedules', 'semesters', 'courses', 'studentId'
        ));
    }

    public function store(Request $request, $studentId)
    {
        // Validate request data
        $request->validate([
            'course_code' => 'required|exists:courses,course_code',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        // Check if the student has already added the course to a different semester
        $existingCourse = StudentCourseSchedule::where('student_id', $studentId)
        ->where('course_code', $request->course_code)
        ->where('semester_id', '<>', $request->semester_id) // Ensure it's not the same semester
        ->exists();

        if ($existingCourse) {
            return redirect()->back()->withErrors(['course_code' => 'You have already added this course to another semester.']);
        }

    
        // Get the course based on the course code
        $course = Course::where('course_code', $request->course_code)->first();
    
        // Check if the course exists
        if (!$course) {
            return redirect()->back()->withErrors([
                'course_code' => 'The selected course does not exist.'
            ]);
        }
    
        // Get all prerequisites for the course from the pivot table
        $prerequisites = $course->prerequisites; // Fetch all prerequisites for the course
    
        // Check if the student has completed all prerequisites
        foreach ($prerequisites as $prerequisite) {
            // Get the semester_id of the current course
            $currentSemesterId = $request->semester_id;
    
            // Get the academic year of the current semester
            $currentSemester = Semester::findOrFail($currentSemesterId);
            $currentAcademicYearId = $currentSemester->academic_year_id;
    
            // Check if the student has taken the prerequisite course in any prior semester of the same or earlier academic years
            $hasTakenPrerequisite = StudentCourseSchedule::where('student_id', $studentId)
                ->where('course_code', $prerequisite->prerequisite_code)
                ->whereHas('semester', function($query) use ($currentAcademicYearId, $currentSemesterId) {
                    // Ensure the prerequisite is taken in the same or earlier academic years
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
    
        // Check if the student is already enrolled in the course for the selected semester
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
            // Add course to the student's schedule
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
