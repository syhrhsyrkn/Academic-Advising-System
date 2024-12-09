<?php

namespace App\Http\Controllers;

use App\Models\AcademicResult;
use App\Models\CourseSchedule;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseScheduleController extends Controller
{

    public function index()
    {
        $matricNo = auth()->user()->matric_no;

        // Group schedules by year and semester
        $schedules = CourseSchedule::where('matric_no', $matricNo)
            ->with(['course'])
            ->get()
            ->groupBy(function ($schedule) {
                return 'Year ' . ceil($schedule->semester_number / 2); 
            })
            ->map(function ($yearGroup) {
                return $yearGroup->groupBy('semester_number');
            });

        // Group courses by classification for the sidebar
        $coursesByClassification = Course::all()->groupBy('classification');

        return view('course-schedule.index', compact('schedules', 'coursesByClassification'));
    }

    /**
     * Store the selected courses for a semester.
     */
    public function store(Request $request)
    {
        $request->validate([
            'semester_number' => 'required|in:1,2,3',
            'academic_year' => 'required|in:Year 1,Year 2,Year 3,Year 4',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,course_code',
        ]);

        $matricNo = auth()->user()->matric_no;

        $totalCredits = Course::whereIn('course_code', $request->courses)->sum('credit_hour');

        if ($totalCredits < 12 || $totalCredits > 20) {
            return back()->withErrors(['message' => 'Total credit hours must be between 12 and 20.']);
        }

        DB::beginTransaction();

        try {
            foreach ($request->courses as $courseCode) {
                $course = Course::with('prerequisites')->where('course_code', $courseCode)->firstOrFail();

                if (!$this->checkPrerequisites($matricNo, $course)) {
                    return back()->withErrors([
                        'message' => "You must complete the prerequisites for {$course->name} before enrolling."
                    ]);
                }

                if ($this->isCourseAlreadyScheduled($matricNo, $request->semester_number, $courseCode)) {
                    return back()->withErrors([
                        'message' => "You are already enrolled in {$course->name} for this semester."
                    ]);
                }

                CourseSchedule::create([
                    'matric_no' => $matricNo,
                    'semester_number' => $request->semester_number,
                    'academic_year' => $request->academic_year,
                    'course_code' => $courseCode,
                ]);
            }

            DB::commit();
            return redirect()->route('course-schedule.index')->with('success', 'Courses added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'An error occurred while processing your request. Please try again.']);
        }
    }

    /**
     * Save the schedule via drag-and-drop functionality.
     */
    public function saveSchedule(Request $request)
    {
        $scheduleData = $request->all();

        DB::beginTransaction();

        try {
            foreach ($scheduleData as $semesterId => $courseCodes) {
                foreach ($courseCodes as $courseCode) {
                    CourseSchedule::updateOrCreate(
                        [
                            'matric_no' => auth()->user()->matric_no,
                            'semester_number' => $semesterId,
                            'course_code' => $courseCode,
                        ],
                        [] // Add additional fields if necessary
                    );
                }
            }

            DB::commit();
            return response()->json(['message' => 'Schedule saved successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while saving the schedule.'], 500);
        }
    }

    /**
     * Check if prerequisites for a course are completed.
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
     * Check if the course is already scheduled.
     */
    private function isCourseAlreadyScheduled($matricNo, $semesterNumber, $courseCode)
    {
        return CourseSchedule::where('matric_no', $matricNo)
            ->where('semester_number', $semesterNumber)
            ->where('course_code', $courseCode)
            ->exists();
    }
}
