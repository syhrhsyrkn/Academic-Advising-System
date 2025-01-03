@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Edit Appointment</h2>
    <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="advising_reason">Advising Reason</label>
            <input type="text" class="form-control" id="advising_reason" name="advising_reason" value="{{ $appointment->advising_reason }}" 
                @if (auth()->user()->hasRole('advisor')) 
                    readonly 
                @endif
            required>
        </div>


        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" id="details" name="details" 
                @if (auth()->user()->hasRole('advisor')) 
                    readonly 
                @endif
            required>{{ $appointment->details }}
            </textarea>
        </div>

        <div class="form-group">
            <label for="appointment_date">Appointment Date</label>
            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" value="{{ $appointment->appointment_date }}" required>        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Appointment</button>
    </form>
</div>
@endsection