<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    // Show the form to add a new course (only for admins)
    public function addCourse()
    {
        return view('course.add-course');
    }

    // Store the new course and redirect back to the add-course page
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses',
            'prerequisite' => 'nullable|string|max:255',
            'credit_hour' => 'required|integer|min:1',
            'description' => 'required|string',
        ]);

        // Create a new course
        Course::create([
            'name' => $request->name,
            'course_code' => $request->course_code,
            'prerequisite' => $request->prerequisite,
            'credit_hour' => $request->credit_hour,
            'description' => $request->description,
        ]);
        Course::create($request->all());

        // Redirect to the same page with a success message
        return redirect()->route('course.create')->with('success', 'Course added successfully');
    }

    // Display the list of courses
    public function index()
    {
        $courses = Course::all();
        return view('course.index-course', compact('courses'));
    }

    // Show a single course
    public function show(Course $course)
    {
        return view('course.show-course', compact('course'));
    }
}
