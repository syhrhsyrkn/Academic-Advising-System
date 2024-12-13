@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Update Appointment</h1>

    <form method="POST" action="{{ route('advisor.update-appointment', $appointment->id) }}">
        @csrf
        @method('PUT')

        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="Scheduled" {{ $appointment->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>Completed</option>
            <option value="Canceled" {{ $appointment->status == 'Canceled' ? 'selected' : '' }}>Canceled</option>
        </select>

        <label for="advising_reason">Advising Reason:</label>
        <input type="text" name="advising_reason" id="advising_reason" value="{{ $appointment->advising_reason }}">

        <label for="appointment_date">Appointment Date:</label>
        <input type="date" name="appointment_date" id="appointment_date" value="{{ $appointment->appointment_date }}">

        <button type="submit">Update</button>
    </form>
</div>
@endsection
