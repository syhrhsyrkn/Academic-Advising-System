@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Student Profile: {{ $student->name }}</h1>

    <div class="profile-details">
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Matric No:</strong> {{ $student->student->matric_no ?? 'N/A' }}</p>
        <p><strong>Contact No:</strong> {{ $student->student->contact_no ?? 'N/A' }}</p>
    </div>

    <a href="{{ route('advisor.student-list') }}">Back to Student List</a>
</div>
@endsection
