@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Your Course Schedule</h2>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <h3>Current Semester Courses</h3>
            <p><strong>Credit Hours:</strong> {{ $totalCredits }} / 20</p>
        </div>

        <!-- Display the courses the student has added to their schedule -->
        <table class="table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credit Hours</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->course_code }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->credit_hour }}</td>
                        <td>
                            <!-- Button to remove course from schedule -->
                            <form action="{{ route('course_schedule.remove', ['id' => $course->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">You have not added any courses for this semester.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Button to add new courses -->
        <a href="{{ route('course_schedule.create', ['matricNo' => $profile->matric_no]) }}" class="btn btn-primary">Add New Courses</a>
    </div>
@endsection
