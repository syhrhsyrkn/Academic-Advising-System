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
    <label for="semester_number">Select Semester:</label>
    <select name="semester_number" id="semester_number" required>
        <option value="1">Semester 1</option>
        <option value="2">Semester 2</option>
        <option value="3">Semester 3</option>
    </select>

    <!-- Select Academic Year -->
    <label for="academic_year">Select Academic Year:</label>
    <select name="academic_year" id="academic_year" required>
        <option value="Year 1">Year 1</option>
        <option value="Year 2">Year 2</option>
        <option value="Year 3">Year 3</option>
        <option value="Year 4">Year 4</option>
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
@foreach($courseSchedules as $academicYear => $semesters)
    <h3>{{ $academicYear }} Courses</h3>
    @foreach($semesters->groupBy('semester_number') as $semesterNumber => $scheduleGroup)
        <h4>Semester {{ $semesterNumber }}</h4>
        <ul>
            @foreach($scheduleGroup as $schedule)
                <li>
                    {{ $schedule->course->name }} ({{ $schedule->course->credit_hour }} credits)
                    @if (auth()->user()->matric_no == $schedule->matric_no)
                        <span> - In Progress</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endforeach
@endforeach

@endsection
