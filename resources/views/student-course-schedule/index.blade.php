@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Course Schedule</h1>

    <form action="{{ route('student_course_schedule.store', $studentId) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="semester_id">Select Semester:</label>
            <select name="semester_id" id="semester_id" class="form-control" required>
                @foreach($semesters as $semester)
                    <option value="{{ $semester->id }}">{{ $semester->name }} (Year {{ $semester->year_id }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="course_code">Select Course:</label>
            <select name="course_code" id="course_code" class="form-control" required>
                @foreach($courses as $course)
                    <option value="{{ $course->course_code }}">{{ $course->course_code }} - {{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add to Schedule</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Current Schedule</h2>
    @if ($schedules->isEmpty())
        <p>No courses in your schedule yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Semester</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->semester->name }}</td>
                        <td>{{ $schedule->course->course_code }} - {{ $schedule->course->name }}</td>
                        <td>
                            <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection