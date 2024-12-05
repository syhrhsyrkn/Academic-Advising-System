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

    // Store the new course
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'course_code' => 'required|string|max:50|unique:courses',
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1',
            'classification' => 'required|in:URC,CCC,DCC,Field Electives,Free Electives, FYP, IAP',
            'prerequisite' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);
        // Create a new course
        Course::create([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'prerequisite' => $request->prerequisite,
            'description' => $request->description,
        ]);

        // Redirect to the same page with a success message
        return redirect()->route('course.create')->with('success', 'Course added successfully');
    }

    // Display the list of courses
    public function index(Request $request)
    {
        // Get sorting parameters
        $sortBy = $request->get('sort_by', 'name'); // Default sort by 'name'
        $order = $request->get('order', 'asc'); // Default order 'asc'

        // Get search query
        $search = $request->get('search'); // Get search parameter

        // Fetch courses, with optional search and sorting
        $courses = Course::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('course_code', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy, $order)
            ->get();

        // Pass current sorting and search parameters to the view
        return view('course.index-course', compact('courses', 'sortBy', 'order', 'search'));
    }

    // Show a single course
    public function show(Course $course)
    {
        return view('course.show-course', compact('course'));
    }

    public function edit($course_code)
    {
        $course = Course::where('course_code', $course_code)->firstOrFail();
        return view('course.edit-course', compact('course'));
    }


    public function update(Request $request, $course_code)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|max:10|unique:courses,course_code,' . $course_code . ',course_code',
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1',
            'classification' => 'required|string',
            'prerequisite' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $course = Course::where('course_code', $course_code)->firstOrFail();
        $course->update($validated);

        return redirect()->route('course.index')->with('success', 'Course updated successfully.');
    }


    public function destroy($course_code)
    {
        $course = Course::where('course_code', $course_code)->firstOrFail();
        $course->delete();

        // Redirect with a success message
        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }

}

