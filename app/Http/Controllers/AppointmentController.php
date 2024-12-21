<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:student')->only('create', 'store');
        $this->middleware('role:advisor')->only('index');
    }

    public function index(Request $request)
    {
        $sortOrder = $request->get('sort', 'asc');

        if (auth()->user()->hasRole('advisor')) {
            $appointments = Appointment::with('user.student')
                ->orderBy('appointment_date', $sortOrder)
                ->get();
        } elseif (auth()->user()->hasRole('student')) {
            $appointments = Appointment::with('user.student')
                ->where('user_id', auth()->id())
                ->orderBy('appointment_date', $sortOrder)
                ->get();
        }

        return view('appointments.index', compact('appointments', 'sortOrder'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'advising_reason' => 'required|string|max:255',
            'details' => 'required|string',
            'appointment_date' => 'required|date|after:today',
        ]);

        $appointment = new Appointment();

        $appointment->user_id = auth()->id();
        $appointment->advising_reason = $request->advising_reason;
        $appointment->details = $request->details;
        $appointment->status = 'Pending';
        $appointment->appointment_date = $request->appointment_date;

        $appointment->save();

        session()->flash('success', 'Your appointment request has been submitted successfully!');

        return redirect()->route('appointments.myAppointments')->with('success', 'Appointment request submitted.');
    }

    public function show($id)
    {
        $appointment = Appointment::findOrFail($id); // Find appointment by ID
        return view('appointments.show', compact('appointment'));
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (!auth()->user()->hasRole('advisor')) {
            abort(403, 'Unauthorized action.');
        }

        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'advising_reason' => 'required|string|max:255',
            'details' => 'required|string',
            'appointment_date' => 'required|date|after:today',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $appointment = Appointment::findOrFail($id);

        $appointment->advising_reason = $request->advising_reason;
        $appointment->details = $request->details;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->status = $request->status;

        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function myAppointments()
    {
        $appointments = Appointment::with('user.student')
            ->where('user_id', auth()->id())
            ->get();

        return view('appointments.myAppointments', compact('appointments'));
    }

    public function latestAppointmentByStudent($studentId)
    {
        $appointment = Appointment::where('user_id', $studentId)
            ->orderBy('appointment_date', 'desc')
            ->first();

        return view('appointments.latest', compact('appointment'));
    }
}
