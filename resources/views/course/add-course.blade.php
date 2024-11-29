@extends('layouts.master')
@section('content')

<!DOCTYPE html>
<html>
<head>
    <title>Add New Course</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Course</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('course.store') }}" method="POST">
                        @csrf

                        <!-- Course Name -->
                        <div class="form-group">
                            <label for="name">Course Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Course Code -->
                        <div class="form-group">
                            <label for="course_code">Course Code</label>
                            <input type="text" name="course_code" class="form-control @error('course_code') is-invalid @enderror" required value="{{ old('course_code') }}">
                            @error('course_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <!-- Credit Hour (CHR) -->
                        <div class="form-group">
                            <label for="credit_hour">Credit Hour</label>
                            <input type="number" name="credit_hour" id="credit_hour" class="form-control @error('credit_hour') is-invalid @enderror" value="{{ old('credit_hour') }}" min="0">
                            @error('credit_hour')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Prerequisite -->
                        <div class="form-group">
                            <label for="prerequisite">Prerequisite</label>
                            <input type="text" name="prerequisite" class="form-control @error('prerequisite') is-invalid @enderror" value="{{ old('prerequisite') }}">
                            @error('prerequisite')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Add Course</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies (Optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>