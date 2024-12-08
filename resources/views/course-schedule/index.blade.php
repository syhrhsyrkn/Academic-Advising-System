@extends('layouts.master')

@section('content')
<h1>Course Schedule</h1>

<!-- Display success or error message -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@elseif ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h2>Your Year of Study: {{ $yearOfStudy }}</h2>

<form action="{{ route('course-schedule.store') }}" method="POST">
    @csrf

    <!-- Select Semester -->
    <label for="semester">Select Semester:</label>
    <select name="semester_id" id="semester" required>
        @foreach($semesters as $semester)
            <option value="{{ $semester->id }}">{{ $semester->name }}</option>
        @endforeach
    </select>

    <!-- Select Courses -->
    <label for="courses">Select Courses:</label>
    <select name="courses[]" id="courses" multiple required>
        @foreach($courses as $course)
            <option value="{{ $course->course_code }}">{{ $course->name }} ({{ $course->credit_hour }} credits)</option>
        @endforeach
    </select>

    <!-- Submit Button -->
    <button type="submit">Add Courses</button>
</form>

<hr>

<!-- Display Existing Courses for the Student in the Selected Semester -->
<h2>Current Courses in Your Schedule</h2>
@foreach($semesters as $semester)
    <h3>{{ $semester->name }}</h3>
    <ul>
        @forelse ($semester->courseSchedules as $schedule)
            <li>
                {{ $schedule->course->name }} ({{ $schedule->course->credit_hour }} credits)
                @if (auth()->user()->matric_no == $schedule->matric_no)
                    <span> - In Progress</span>
                @endif
            </li>
        @empty
            <li>No courses scheduled for this semester.</li>
        @endforelse
    </ul>
@endforeach

@endsection
