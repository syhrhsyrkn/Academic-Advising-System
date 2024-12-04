<?php 

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function addCourse()
    {
        return view('course.add-course');
    }

    // Store the new course
    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:10|unique:courses',
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1',
            'classification' => 'required|in:URC,CCC,DCC,Field Electives,Free Electives, FYP, IAP',
            'prerequisites' => 'array|exists:courses,course_code', // Change this validation to match course_code
            'description' => 'required|string',
        ]);

        // Create a new course
        $course = Course::create([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'description' => $request->description,
        ]);

        // Attach prerequisites using the pivot table
        if ($request->has('prerequisites')) {
            $course->prerequisites()->attach($request->prerequisites);
        }

        // Redirect to the same page with a success message
        return redirect()->route('course.create')->with('success', 'Course added successfully');
    }

    // Display the list of courses
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'name');
        $order = $request->get('order', 'asc');

        $courses = Course::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('course_code', 'LIKE', "%{$search}%");
            })
            ->orderBy($sortBy, $order)
            ->paginate(10);

        return view('courses.index', compact('courses', 'search', 'sortBy', 'order'));
    }

    // Show a single course
    public function show(Course $course)
    {
        return view('course.show-course', compact('course'));
    }

    // Show the form for editing a course
    public function edit(Course $course)
    {
        return view('course.edit-course', compact('course'));
    }

    // Update the course in the database
    public function update(Request $request, Course $course)
    {
        // Validate the request
        $request->validate([
            'course_code' => 'required|string|max:50|unique:courses,course_code,' . $course->id,
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|integer|min:1',
            'classification' => 'required|in:URC,CCC,DCC,Field Electives,Free Electives, FYP, IAP',
            'prerequisites' => 'array|exists:courses,course_code', 
            'description' => 'required|string',
        ]);

        // Update the course
        $course->update([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'description' => $request->description,
        ]);

        if ($request->has('prerequisites')) {
            $course->prerequisites()->sync($request->prerequisites); // Sync prerequisites to the course
        } else {
            $course->prerequisites()->detach(); // Detach all prerequisites if none are selected
        }

        // Redirect with a success message
        return redirect()->route('course.index')->with('success', 'Course updated successfully');
    }

    // Delete a course
    public function destroy(Course $course)
    {
        $course->delete();

        // Redirect with a success message
        return redirect()->route('course.index')->with('success', 'Course deleted successfully');
    }
}
