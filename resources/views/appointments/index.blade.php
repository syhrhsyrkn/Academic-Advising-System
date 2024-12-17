@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Appointment List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Appt No</th>
                <th>Matric Number</th>
                <th>Name</th>
                <th>Contact No</th>
                <th>Email</th>
                <th>Advising Reason</th>
                <th>Appointment Date</th>
                <th>Status</th>
                @role('advisor')
                <th>Actions</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $appointment->user->student->matric_no ?? 'N/A' }}</td>
                <td>{{ $appointment->user->name ?? 'N/A' }}</td>
                <td>{{ $appointment->user->student->contact_no ?? 'N/A' }}</td>
                <td>{{ $appointment->user->email ?? 'N/A' }}</td>
                <td>{{ $appointment->advising_reason }}</td>
                <td>{{ $appointment->appointment_date }}</td>
                <td>{{ $appointment->status }}</td>
                @role('advisor')
                <td>
                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">Edit</a>
                </td>
                @endrole
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
