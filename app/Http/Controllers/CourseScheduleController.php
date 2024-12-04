<?php

namespace App\Http\Controllers;

use App\Models\CourseSchedule;
use App\Models\Course;
use App\Models\Profile;
use Illuminate\Http\Request;

class CourseScheduleController extends Controller
{
    // Display all course schedules for a student
    public function index($matricNo)
    {
        // Fetch the profile based on matricNo
        $profile = Profile::where('matric_no', $matricNo)->firstOrFail();

        // Fetch the current semester's schedule and calculate total credits
        $currentSchedule = CourseSchedule::where('matric_no', $matricNo)
            ->where('semester', $profile->semester)
            ->where('year', now()->year) // Example logic for the current year
            ->get();

        $totalCredits = $currentSchedule->sum(function ($schedule) {
            return $schedule->course->credit_hour ?? 0; // Sum credit hours from related courses
        });

        $courses = $currentSchedule->map(function ($schedule) {
            return $schedule->course; // Map to related course details
        });

        return view('course_schedule.index', compact('courses', 'totalCredits', 'profile'));
    }

    // Show the form to add courses for a semester
    public function create($matricNo)
    {
        $profile = Profile::where('matric_no', $matricNo)->firstOrFail();
        $availableCourses = Course::all(); // Get all available courses
        return view('course_schedule.create', compact('availableCourses', 'profile'));
    }

    // Store the course schedule for a student
    public function store(Request $request, $matricNo)
    {
        $request->validate([
            'course_code' => 'required|exists:courses,course_code', // Validate if course exists
        ]);

        $profile = Profile::where('matric_no', $matricNo)->firstOrFail();

        $semester = $profile->semester;
        $year = now()->year;

        // Check if the course already exists in the student's schedule
        $existingCourse = CourseSchedule::where('matric_no', $matricNo)
            ->where('course_code', $request->course_code)
            ->where('semester', $semester)
            ->where('year', $year)
            ->first();

        if ($existingCourse) {
            return redirect()->route('course_schedule.index', ['matricNo' => $matricNo])
                ->withErrors(['course_code' => 'This course is already in your schedule.']);
        }

        // Calculate total credit hours if the course is added
        $totalCredits = CourseSchedule::where('matric_no', $matricNo)
            ->where('semester', $semester)
            ->where('year', $year)
            ->sum('total_credit_hour') + Course::where('course_code', $request->course_code)->value('credit_hour');

        if ($totalCredits > 20) {
            return redirect()->route('course_schedule.index', ['matricNo' => $matricNo])
                ->withErrors(['course_code' => 'Adding this course exceeds the maximum credit hour limit (20).']);
        }

        // Store the new course schedule
        CourseSchedule::create([
            'matric_no' => $matricNo,
            'course_code' => $request->course_code,
            'semester' => $semester,
            'year' => $year,
            'total_credit_hour' => Course::where('course_code', $request->course_code)->value('credit_hour'),
        ]);

        return redirect()->route('course_schedule.index', ['matricNo' => $matricNo])
            ->with('success', 'Course added successfully to your schedule.');
    }

    // Show the details of a specific course schedule
    public function show($matricNo, $id)
    {
        $courseSchedule = CourseSchedule::where('id', $id)
            ->where('matric_no', $matricNo)
            ->firstOrFail();

        return view('course_schedule.show', compact('courseSchedule'));
    }

    // Remove a course from the student's schedule
    public function remove($matricNo, $id)
    {
        $courseSchedule = CourseSchedule::where('id', $id)
            ->where('matric_no', $matricNo)
            ->firstOrFail();

        $courseSchedule->delete();

        return redirect()->route('course_schedule.index', ['matricNo' => $matricNo])
            ->with('success', 'Course removed from your schedule.');
    }
}
