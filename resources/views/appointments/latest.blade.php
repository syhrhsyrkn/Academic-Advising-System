@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Latest Appointment</h2>

    @if (isset($appointment))
        <table class="table">
            <thead>
                <tr>
                    <th>Advising Reason</th>
                    <th>Details</th>
                    <th>Appointment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $appointment->advising_reason }}</td>
                    <td>{{ $appointment->details }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y H:i') }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p class="alert alert-warning">No appointment request found for this student.</p>
    @endif
</div>
@endsection
