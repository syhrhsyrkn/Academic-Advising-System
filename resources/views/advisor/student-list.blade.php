@extends('layouts.master')

@section('content')
<div class="container">
    <h1>List of Students</h1>
    
    <!-- Filter by Academic Year -->
    <form method="GET" action="{{ route('advisor.student-list') }}">
        <label for="academic_year">Filter by Academic Year:</label>
        <select name="academic_year" id="academic_year" onchange="this.form.submit()">
            <option value="">All</option>
            @foreach($academicYears as $year)
                <option value="{{ $year->id }}" {{ request('academic_year') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }}
                </option>
            @endforeach
        </select>
    </form>

    <!-- Student Table -->
    <table cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Matric No</th>
                <th>Contact No</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @php
                    $latestAppointment = $student->appointments->first();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->student->matric_no ?? 'N/A' }}</td>
                    <td>{{ $student->student->contact_no ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('advisor.view-student-profile', $student->id) }}" class="me-4">Profile</a>
                        <a href="{{ route('advisor.student-schedule', $student->id) }}" class="me-4">Schedule</a>
                        <a href="{{ route('advisor.student-academic-result', $student->id) }}" class="me-4">Academic Result</a>                        
                        <a href="{{ route('appointments.latest', $student->id) }}" class="me-4">Appointment</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No students found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
