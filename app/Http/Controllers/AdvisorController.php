<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    // View the list of students
    public function studentList()
    {
        $students = User::role('student')->get();
        return view('advisor.student-list', compact('students'));
    }

    // View a student's profile
    public function viewStudentProfile($id)
    {
        $student = User::findOrFail($id);
        return view('advisor.student-profile', compact('student'));
    }

    // View a student's course schedule
    public function viewStudentSchedule($id)
    {
        $student = User::findOrFail($id);
        $courses = $student->courses; // Assuming a relationship exists
        return view('advisor.student-schedule', compact('student', 'courses'));
    }

    // View a student's academic results
    public function viewStudentResults($id)
    {
        $student = User::findOrFail($id);
        $results = $student->results; // Assuming a relationship exists
        return view('advisor.student-results', compact('student', 'results'));
    }
}
