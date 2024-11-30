@extends('layouts.master')
@section('content')

<div class="container">
    <h2>Edit Profile</h2>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="{{ $profile->full_name }}" required>
        </div>

        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ $profile->contact_number }}" required>
        </div>

        @if(auth()->user()->hasRole('student'))
            <div class="form-group">
                <label>Matric No</label>
                <input type="text" name="matric_no" class="form-control" value="{{ $profile->matric_no }}">
            </div>
            <div class="form-group">
                <label>Specialisation</label>
                <input type="text" name="specialisation" class="form-control" value="{{ $profile->specialisation }}">
            </div>
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" class="form-control" value="{{ $profile->year }}">
            </div>
            <div class="form-group">
                <label>Semester</label>
                <input type="number" name="semester" class="form-control" value="{{ $profile->semester }}">
            </div>
        @endif
        
        <div class="form-group">
            <label>Kulliyyah</label>
            <input type="text" name="kulliyyah" class="form-control" value="{{ $profile->kulliyyah }}" required>
        </div>

        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department" class="form-control" value="{{ $profile->department }}" required>
        </div>

        @if(auth()->user()->hasRole(['advisor', 'admin']))
            <div class="form-group">
                <label>Staff ID</label>
                <input type="text" name="staff_id" class="form-control" value="{{ $profile->staff_id }}">
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

@endsection
