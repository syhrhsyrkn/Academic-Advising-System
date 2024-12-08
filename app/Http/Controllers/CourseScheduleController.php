<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\CourseSchedule;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseScheduleController extends Controller
{
    /**
     * Display the course schedule index page.
     */
    public function index()
    {
        $matricNo = auth()->user()->matric_no;
    
        // Fetch semesters and calculate Year of Study
        $semesters = Semester::with(['courseSchedules' => function ($query) use ($matricNo) {
            $query->where('matric_no', $matricNo)->with('course');
        }])->get();
    
        // Calculate the year of study based on enrolled semesters
        $yearOfStudy = $this->getYearOfStudy($matricNo);
    
        // Fetch all available courses for the student
        $courses = Course::all();
    
        return view('course-schedule.index', compact('semesters', 'yearOfStudy', 'courses'));
    }

    /**
     * Determine the year of study based on enrolled semesters.
     */
    public function getYearOfStudy($matricNo)
    {
        // Count the number of semesters the student is enrolled in
        $semesterCount = CourseSchedule::where('matric_no', $matricNo)->count();

        // Determine the year of study based on the semester count
        if ($semesterCount <= 2) {
            return 'Year 1';
        } elseif ($semesterCount <= 4) {
            return 'Year 2';
        } elseif ($semesterCount <= 6) {
            return 'Year 3';
        } else {
            return 'Year 4';
        }
    }

    /**
     * Store the selected courses for the student in the course schedule.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,course_code',
        ]);

        // Get matric number of the authenticated user
        $matricNo = auth()->user()->matric_no;

        // Calculate total credits for the selected courses
        $totalCredits = Course::whereIn('course_code', $request->courses)->sum('credit_hour');

        // Check if the total credits are within the acceptable range
        if ($totalCredits < 12 || $totalCredits > 20) {
            return back()->withErrors(['message' => 'Total credit hours must be between 12 and 20.']);
        }

        // Start a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Loop through the selected courses to add them to the schedule
            foreach ($request->courses as $courseCode) {
                $course = Course::with('prerequisites')->where('course_code', $courseCode)->firstOrFail();

                // Check prerequisites for the selected course
                if (!$this->checkPrerequisites($matricNo, $course)) {
                    return back()->withErrors([ 
                        'message' => "You must complete the prerequisites for {$course->name} before enrolling."
                    ]);
                }

                // Check if the student is already enrolled in the course for the selected semester
                if ($this->isCourseAlreadyScheduled($matricNo, $request->semester_id, $courseCode)) {
                    return back()->withErrors([ 
                        'message' => "You are already enrolled in {$course->name} for this semester."
                    ]);
                }

                // Add the course to the course schedule
                CourseSchedule::create([
                    'matric_no' => $matricNo,
                    'semester_id' => $request->semester_id,
                    'course_code' => $courseCode,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect back with success message
            return redirect()->route('course-schedule.index')->with('success', 'Courses added successfully.');

        } catch (\Exception $e) {
            // Rollback the transaction in case of any error
            DB::rollBack();
            return back()->withErrors(['message' => 'An error occurred while processing your request. Please try again.']);
        }
    }

    /**
     * Helper method to check if prerequisites for a course are completed.
     */
    private function checkPrerequisites($matricNo, $course)
    {
        foreach ($course->prerequisites as $prerequisite) {
            $prerequisiteCompleted = AcademicResult::where('matric_no', $matricNo)
                ->where('course_code', $prerequisite->course_code)
                ->whereNotNull('grade')
                ->exists();

            if (!$prerequisiteCompleted) {
                return false;
            }
        }

        return true;
    }

    /**
     * Helper method to check if the student is already enrolled in the course for the selected semester.
     */
    private function isCourseAlreadyScheduled($matricNo, $semesterId, $courseCode)
    {
        return CourseSchedule::where('matric_no', $matricNo)
            ->where('semester_id', $semesterId)
            ->where('course_code', $courseCode)
            ->exists();
    }
}
