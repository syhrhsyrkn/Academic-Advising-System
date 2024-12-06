<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Display the form for adding a course
    public function create()
    {
        $availableCourses = Course::all();
        return view('course.add-course', compact('availableCourses'));
    }

    // Store a new course
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'course_code' => 'required|string|max:50|unique:courses',
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1|max:20',
            'classification' => 'required|in:URC,CCC,DCC,Field Electives,Free Electives,FYP,IAP',
            'prerequisites' => 'array|exists:courses,course_code',
            'description' => 'required|string|max:1000',
        ]);

        // Create the course
        $course = Course::create([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'prerequisite' => $request->prerequisite,
            'description' => $request->description,
        ]);

        // Attach prerequisites if provided
        if ($request->has('prerequisites')) {
            $course->prerequisites()->attach($request->prerequisites);
        }

        return redirect()->route('course.index')->with('success', 'Course added successfully.');
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

        return view('course.index-course', compact('courses', 'search', 'sortBy', 'order'));
    }

    // Show the details of a single course
    public function show(Course $course)
    {
        $course->load('prerequisites');
        return view('course.show-course', compact('course'));
    }

    public function edit($course_code)
    {
        $availableCourses = Course::all();
        $course->load('prerequisites');
        return view('course.edit-course', compact('course', 'availableCourses'));
    }

    // Update a course
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_code' => 'required|string|max:10|unique:courses,course_code,' . $course->id,
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1|max:20',
            'classification' => 'required|in:URC,CCC,DCC,Field Electives,Free Electives,FYP,IAP',
            'prerequisites' => 'array|exists:courses,course_code',
            'description' => 'required|string|max:1000',
        ]);

        // Update course details
        $course->update([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'description' => $request->description,
        ]);

        // Sync prerequisites
        if ($request->has('prerequisites')) {
            $course->prerequisites()->sync($request->prerequisites);
        } else {
            $course->prerequisites()->detach();
        }

        return redirect()->route('course.index')->with('success', 'Course updated successfully.');
    }


    public function destroy($course_code)
    {
        $course->prerequisites()->detach(); // Detach all prerequisites first
        $course->delete();

        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }

}

