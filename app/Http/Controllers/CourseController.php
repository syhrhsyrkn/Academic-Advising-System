<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct()
    {
        // Define middleware for role-specific access
        $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        $this->middleware('role:admin|advisor|student')->only(['index', 'show']);
    }

    // View all courses (accessible to admin, advisor, and student)
    public function index()
    {
        $courses = Course::all();
        return view('course.index-course', compact('courses'));
    }

    // View a specific course (accessible to admin, advisor, and student)
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }


    public function create()
    {
        return view('course.add-course'); 
    }

    // Store a new course (accessible to admin only)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:courses',
            'description' => 'nullable|string',
            'prerequisite' => 'nullable|string',
        ]);

        Course::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'prerequisite' => $request->prerequisite,
        ]);

        return redirect()->route('course.index')->with('success', 'Course created successfully.');
    }

    // Show the page to edit a course (accessible to admin only)
    public function edit(Course $course)
    {
        return view('course.edit', compact('course'));
    }

    // Update an existing course (accessible to admin only)
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'nullable|string',
            'prerequisite' => 'nullable|string',
        ]);

        $course->update($request->all());

        return redirect()->route('course.index')->with('success', 'Course updated successfully.');
    }
    
    // Allow only admins to delete a course.
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }
    

}