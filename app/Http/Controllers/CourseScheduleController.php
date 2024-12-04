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
        $courseSchedules = CourseSchedule::where('matric_no', $matricNo)->get();
        return view('course_schedule.index', compact('courseSchedules'));
    }

    // Show the form to add courses for a semester
    public function create($matricNo)
    {
        $courses = Course::all(); // Get all available courses
        return view('course_schedule.create', compact('courses', 'matricNo'));
    }

    // Store the course schedule for a student
    public function store(Request $request, $matricNo)
    {
        $request->validate([
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,course_code', // Validate if course exists in courses table
            'semester' => 'required|in:1,2,3',
            'year' => 'required|integer',
            'total_credit_hour' => 'required|integer|min:12|max:20',
        ]);

        // Store the course schedule for the student
        foreach ($request->courses as $courseCode) {
            CourseSchedule::create([
                'matric_no' => $matricNo,
                'course_code' => $courseCode,
                'semester' => $request->semester,
                'year' => $request->year,
                'total_credit_hour' => $request->total_credit_hour,
            ]);
        }

        return redirect()->route('course_schedule.index', $matricNo)->with('success', 'Course schedule created successfully');
    }

    // Show the details of a specific course schedule
    public function show($matricNo, $id)
    {
        $courseSchedule = CourseSchedule::findOrFail($id);
        return view('course_schedule.show', compact('courseSchedule'));
    }
}

