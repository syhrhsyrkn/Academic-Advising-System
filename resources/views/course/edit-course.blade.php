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

                    <form action="{{ route('course.update', $course->course_code) }}" method="POST">
                        @csrf
                        @method('PUT')

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

                        <!-- Credit Hour -->
                        <div class="form-group">
                            <label for="credit_hour">Credit Hour</label>
                            <input type="number" name="credit_hour" class="form-control @error('credit_hour') is-invalid @enderror" value="{{ old('credit_hour', $course->credit_hour) }}" min="1" max="20" required>
                            @error('credit_hour')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Course Classification -->
                        <div class="form-group">
                            <label for="classification">Classification</label>
                            <select name="classification" class="form-select" required>
                                <option value="" disabled>Select Classification</option>
                                <option value="URC" {{ old('classification', $course->classification) == 'URC' ? 'selected' : '' }}>University Required Courses (URC)</option>
                                <option value="CCC" {{ old('classification', $course->classification) == 'CCC' ? 'selected' : '' }}>Core Computing Courses (CCC)</option>
                                <option value="DCC" {{ old('classification', $course->classification) == 'DCC' ? 'selected' : '' }}>Discipline Core Courses (DCC)</option>
                                <option value="Electives" {{ old('classification', $course->classification) == 'Electives' ? 'selected' : '' }}>Electives</option>
                                <option value="FYP" {{ old('classification', $course->classification) == 'FYP' ? 'selected' : '' }}>Final Year Project (FYP)</option>
                                <option value="IAP" {{ old('classification', $course->classification) == 'IAP' ? 'selected' : '' }}>Industrial Attachment (IAP)</option>
                            </select>
                            @error('classification')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Prerequisites -->
                        <div class="form-group">
                            <label for="prerequisites">Prerequisites</label>
                            <select name="prerequisites[]" id="prerequisites" class="form-control" multiple>
                                @foreach($availableCourses as $availableCourse)
                                    <option value="{{ $availableCourse->course_code }}" 
                                        {{ in_array($availableCourse->course_code, old('prerequisites', $course->prerequisites->pluck('prerequisite_code')->toArray() ?? [])) ? 'selected' : '' }}>
                                        {{ $availableCourse->course_code }} - {{ $availableCourse->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prerequisites')
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
