<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function create()
    {
        $availableCourses = Course::all();
        return view('course.add-course', compact('availableCourses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|string|max:50|unique:courses',
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|numeric|min:0',
            'classification' => 'required|in:URC,CCC,DCC,Electives,FYP,IAP',
            'prerequisites' => 'array|exists:courses,course_code',
            'description' => 'required|string|max:1000',
        ]);

        $course = Course::create([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'description' => $request->description,
        ]);

        if ($request->has('prerequisites')) {
            $course->prerequisites()->attach($request->prerequisites);
        }

        return redirect()->route('course.index')->with('success', 'Course added successfully.');
    }

    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'name');
        $order = $request->get('order', 'asc');
    
        $search = $request->get('search');
    
        $courses = Course::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('course_code', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy, $order)
            ->paginate(10);  
    
        return view('course.index-course', compact('courses', 'search', 'sortBy', 'order'));
    }
    

    public function show(Course $course)
    {
        $course->load('prerequisites');
        return view('course.show-course', compact('course'));
    }

    public function edit($course_code)
    {
        $course = Course::where('course_code', $course_code)->firstOrFail();
        $availableCourses = Course::all();
        $course->load('prerequisites');
        return view('course.edit-course', compact('course', 'availableCourses'));
    }

    public function update(Request $request, $course_code)
    {
        $course = Course::where('course_code', $course_code)->firstOrFail();
        $existingCourse = Course::where('course_code', $request->course_code)->first();

        if ($existingCourse && $existingCourse->course_code != $course->course_code) {
            return back()->withErrors(['course_code' => 'The course code has already been taken.']);
        }

        $request->validate([
            'course_code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'credit_hour' => 'required|numeric|min:0',
            'classification' => 'required|in:URC,CCC,DCC,Electives,FYP,IAP',
            'prerequisites' => 'array|exists:courses,course_code',
            'description' => 'required|string|max:1000',
        ]);

        // Update course fields
        $course->update([
            'course_code' => $request->course_code,
            'name' => $request->name,
            'credit_hour' => $request->credit_hour,
            'classification' => $request->classification,
            'description' => $request->description,
        ]);

        if ($request->has('prerequisites')) {
            $course->prerequisites()->sync($request->prerequisites);
        } else {
            $course->prerequisites()->detach();
        }

        return redirect()->route('course.index')->with('success', 'Course updated successfully.');
    }


    public function destroy($course_code)
    {
        $course = Course::where('course_code', $course_code)->firstOrFail();
        $course->prerequisites()->detach();  // Detach prerequisites
        $course->delete();  // Delete the course

        return redirect()->route('course.index')->with('success', 'Course deleted successfully.');
    }

}
