@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Add Courses to Your Schedule</h2>

        <!-- Display Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('course_schedule.store', ['matricNo' => $profile->matric_no]) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="course_code" class="form-label">Course Code</label>
                <select name="course_code" id="course_code" class="form-control">
                    <option value="">Select a course</option>
                    @foreach($availableCourses as $course)
                        <option value="{{ $course->course_code }}">{{ $course->course_code }} - {{ $course->name }}</option>
                    @endforeach
                </select>
                @error('course_code')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>

        <!-- Display the total credit hour validation -->
        <p class="mt-3"><strong>Note:</strong> You must have at least 12 and no more than 20 credit hours in a semester.</p>
    </div>
@endsection

