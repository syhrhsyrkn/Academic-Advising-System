@extends('layouts.master')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Courses List</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('course.create') }}" class="btn btn-primary mb-3">Add New Course</a>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>Credit Hour</th>
                                <th>Prerequisite</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->credit_hour }}</td>
                                    <td>{{ $course->prerequisite }}</td>
                                    <td>{{ $course->description }}</td>
                                    <td>
                                        @if(auth()->user()->hasRole('admin'))
                                            <a href="{{ route('course.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                                            <a href="{{ route('course.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('course.index', $course->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                            </form>
                                        @elseif(auth()->user()->hasRole('advisor') || auth()->user()->hasRole('student'))
                                            <a href="{{ route('course.show', $course->id) }}" class="btn btn-info btn-sm">View</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No courses available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
