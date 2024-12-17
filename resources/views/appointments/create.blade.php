@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="advising_reason">Advising Reason</label>
            <input type="text" class="form-control" id="advising_reason" name="advising_reason" required>
            @error('advising_reason') 
                <div class="text-danger">{{ $message }}</div> 
            @enderror
        </div>
        <div class="form-group">
            <label for="appointment_date">Appointment Date</label>
            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
            @error('appointment_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
</div>
@endsection
