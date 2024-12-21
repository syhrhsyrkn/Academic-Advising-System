@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>
    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="advising_reason">Advising Reason</label>
            <select class="form-control" id="advising_reason" name="advising_reason" required>
                <option value="">Select a reason</option>
                <option value="Study plan consultation">Study plan consultation</option>
                <option value="Issues with course registration">Issues with course registration</option>
                <option value="Issues with transfer of credits">Issues with transfer of credits</option>
                <option value="Appeal for exceed workload">Appeal for exceed workload</option>
                <option value="Appeal for change of program">Appeal for change of program</option>
                <option value="Consultation on leave of absence">Consultation on leave of absence</option>
                <option value="Others">Others</option>
            </select>
            @error('advising_reason') 
                <div class="text-danger">{{ $message }}</div> 
            @enderror
        </div>
        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" id="details" name="details" rows="4" required></textarea>
            @error('details') 
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
