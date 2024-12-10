<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:student')->only('create', 'store');
        $this->middleware('role:advisor')->only('index', 'show');
    }

    public function index()
    {
        $appointments = Appointment::with('user.profile')
            ->whereHas('user', function($query) {
                $query->whereHas('roles', function($query) {
                    $query->where('name', 'student');
                });
            })
            ->get();
        
        return view('appointments.index', compact('appointments'));
    }

    // Show a form to create an appointment (only for students)
    public function create()
    {
        return view('appointments.create');
    }

    // Store an appointment (only for students)
    public function store(Request $request)
    {
        $request->validate([
            'advising_reason' => 'required|string|max:255',
        ]);

        $appointment = new Appointment();
        $appointment->user_id = Auth::id(); // Store the logged-in student's ID
        $appointment->advising_reason = $request->advising_reason;
        $appointment->status = 'Pending';
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment request submitted.');
    }

    // Show the details of a specific appointment for the advisor
    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return view('appointments.show', compact('appointment'));
    }
}
