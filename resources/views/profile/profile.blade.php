@extends('layouts.master')
@section('content')

<div class="container">
    <h2>Profile</h2>

    <div>
        <h4>Full Name: {{ $profile->full_name }}</h4>
        <p>Contact Number: {{ $profile->contact_number }}</p>
        <p>Kulliyyah: {{ $profile->kulliyyah }}</p>
        <p>Department: {{ $profile->department }}</p>
        @if(auth()->user()->hasRole('student'))
            <p>Matric No: {{ $profile->matric_no }}</p>
            <p>Specialisation: {{ $profile->specialisation }}</p>
            <p>Year: {{ $profile->year }}</p>
            <p>Semester: {{ $profile->semester }}</p>
        @endif
        @if(auth()->user()->hasRole(['advisor', 'admin']))
            <p>Staff ID: {{ $profile->staff_id }}</p>
        @endif
    </div>

    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
</div>

@endsection
