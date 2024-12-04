@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ $course->name }} Details</h4>
                </div>
                <div class="card-body">
                    <p><strong>Course Code:</strong> {{ $course->course_code }}</p>
                    <p><strong>Credit Hour:</strong> {{ $course->credit_hour }}</p>
                    <p><strong>Classification:</strong> {{ $course->classification }}</p>
                    <p><strong>Prerequisites:</strong></p>
                        @if($course->prerequisites->isNotEmpty())
                            <ul>
                                @foreach($course->prerequisites as $prerequisite)
                                    <li>{{ $prerequisite->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>None</p>
                        @endif                    
                    <p><strong>Description:</strong> {{ $course->description }}</p>

                    <a href="{{ route('course.index') }}" class="btn btn-secondary">Back to Course List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
