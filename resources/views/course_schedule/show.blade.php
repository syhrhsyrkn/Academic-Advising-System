@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Course Details</h2>

        <div class="mb-3">
            <h3>{{ $course->course_code }} - {{ $course->name }}</h3>
            <p><strong>Credit Hours:</strong> {{ $course->credit_hour }}</p>
            <p><strong>Description:</strong> {{ $course->description ?? 'No description available' }}</p>
        </div>

        <div class="mb-3">
            <h4>Prerequisites</h4>
            <ul>
                @forelse($course->prerequisites as $prerequisite)
                    <li>{{ $prerequisite->course_code }} - {{ $prerequisite->name }}</li>
                @empty
                    <li>No prerequisites for this course.</li>
                @endforelse
            </ul>
        </div>

        <a href="{{ route('course_schedule.index') }}" class="btn btn-secondary">Back to Schedule</a>
    </div>
@endsection
