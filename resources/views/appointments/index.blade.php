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
                <th>Appointment Date 
                    <a href="{{ route('appointments.index', ['sort' => 'asc']) }}">▲</a>
                    <a href="{{ route('appointments.index', ['sort' => 'desc']) }}">▼</a></th>
                <th>Status</th>
                @role('advisor')
                <th>Actions</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr class="{{ $appointment->status === 'Pending' ? 'table-warning' : '' }}">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $appointment->user->student->matric_no ?? 'N/A' }}</td>
                <td>{{ $appointment->user->name ?? 'N/A' }}</td>
                <td>{{ $appointment->user->student->contact_no ?? 'N/A' }}</td>
                <td>{{ $appointment->user->email ?? 'N/A' }}</td>
                <td>{{ $appointment->advising_reason }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d-m-Y H:i') }}</td>
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

<style>
    .container {
    margin-left: 100px;
}
</style>
@endsection
