<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    public function studentList(Request $request)
    {
        // Fetch academic years for filtering
        $academicYears = AcademicYear::all();

        // Fetch students with related data from student and appointment tables
        $students = User::role('student')
            ->with(['student', 'appointments' => function ($query) {
                $query->latest(); // Ensure appointments are sorted by latest
            }])
            ->whereHas('student', function ($query) use ($request) {
                if ($request->has('academic_year')) {
                    $query->where('academic_year_id', $request->academic_year); // Filter by academic year
                }
            })
            ->get();

        return view('advisor.student-list', compact('students', 'academicYears'));
    }

    public function viewStudentProfile(User $student)
    {
        if (!$student->hasRole('student')) {
            abort(403, 'Unauthorized action.');
        }
    
        $studentDetails = $student->student;
        $academicResults = $studentDetails ? $studentDetails->academicResults : []; 
    
        return view('advisor.student-profile', ['student' => $student,'studentDetails' => $studentDetails,'academicResults' => $academicResults,]);
    }
    

    public function viewStudentSchedule(User $student)
    {
        if (!$student->hasRole('student')) {
            abort(403, 'Unauthorized action.');
        }
    
        $student = Student::with('courseSchedules.course', 'courseSchedules.semester')->find($studentId);
    
        return view('advisor.student-schedule', ['student' => $student,'courseSchedule' => $courseSchedule,]);
    }
    

    public function editAppointment(Appointment $appointment)
    {
        return view('advisor.edit-appointment', compact('appointment'));
    }

    public function updateAppointment(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|string|in:Scheduled,Completed,Canceled',
            'advising_reason' => 'nullable|string|max:255',
            'appointment_date' => 'required|date',
        ]);

        $appointment->update([
            'status' => $request->status,
            'advising_reason' => $request->advising_reason,
            'appointment_date' => $request->appointment_date,
        ]);

        return redirect()->route('advisor.student-list')->with('success', 'Appointment updated successfully!');
    }

    public function viewAllAppointments(Request $request)
    {
        $status = $request->input('status');
        $date = $request->input('date');
    
        $query = Appointment::with(['user', 'user.student']);
    
        if ($status) {
            $query->where('status', $status);
        }
    
        if ($date) {
            $query->whereDate('appointment_date', $date);
        }
    
        $appointments = $query->paginate(10);
    
        return view('advisor.appointment-list', ['appointments' => $appointments,'filters' => ['status' => $status,'date' => $date,],]);
    }
    
}
