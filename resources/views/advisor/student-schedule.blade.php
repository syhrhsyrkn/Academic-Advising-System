@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Course Schedule for {{ $student->name }}</h1>
    
    <p>Matric No: {{ $student->student->matric_no }}</p>
    <p>Contact No: {{ $student->student->contact_no }}</p>

    <h2>Semester Schedule</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credit Hours</th>
                <th>Prerequisites</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courseSchedule as $course)
                <tr>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_name }}</td>
                    <td>{{ $course->credit_hours }}</td>
                    <td>{{ $course->prerequisites }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No courses scheduled for this semester.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
