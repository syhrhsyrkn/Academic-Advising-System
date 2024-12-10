@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Your Appointments</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Advising Reason</th>
                <th>Status</th>
                <th>Appointment Date</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($appointments as $appointment)
        <tr>
            <td>{{ $appointment->profile->matric_no ?? 'N/A' }}</td>
            <td>{{ $appointment->advising_reason }}</td>
            <td>{{ $appointment->status }}</td>
            <td>{{ $appointment->appointment_date }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
