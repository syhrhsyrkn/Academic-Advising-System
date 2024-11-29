@extends('layouts.master')
@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Course</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('course.update', $course->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Course Name -->
                        <div class="form-group">
                            <label for="name">Course Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $course->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Course Code -->
                        <div class="form-group">
                            <label for="course_code">Course Code</label>
                            <input type="text" name="course_code" class="form-control @error('course_code') is-invalid @enderror" value="{{ old('course_code', $course->course_code) }}" required>
                            @error('course_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Credit Hour -->
                        <div class="form-group">
                            <label for="credit_hour">Credit Hour</label>
                            <input type="number" name="credit_hour" class="form-control @error('credit_hour') is-invalid @enderror" value="{{ old('credit_hour', $course->credit_hour) }}" min="1" required>
                            @error('credit_hour')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Prerequisite -->
                        <div class="form-group">
                            <label for="prerequisite">Prerequisite</label>
                            <input type="text" name="prerequisite" class="form-control @error('prerequisite') is-invalid @enderror" value="{{ old('prerequisite', $course->prerequisite) }}">
                            @error('prerequisite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $course->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Update Course</button>
                        <a href="{{ route('course.index') }}" class="btn btn-secondary">Back to Course List</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
