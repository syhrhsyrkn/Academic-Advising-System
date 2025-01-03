@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Your Appointments</h2>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <table class="table">
        <thead>
            <tr>
                <th>Advising Reason</th>
                <th>Details</th> 
                <th>Status</th>
                <th>Appointment Date</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($appointments as $appointment)
        <tr>
            <td>{{ $appointment->advising_reason }}</td>
            <td>{{ $appointment->details }}</td> 
            <td>{{ $appointment->status }}</td>
            <td>{{ $appointment->appointment_date }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">You have not submitted any appointment requests yet.</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
