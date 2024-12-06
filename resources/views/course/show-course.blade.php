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

                    <form method="GET" action="{{ route('course.index') }}" class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search by course name or course code" value="{{ $search }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    @if($search)
                        <a href="{{ route('course.index') }}" class="btn btn-secondary mb-3">Clear Search</a>
                    @endif

                    @role('admin')
                        <a href="{{ route('course.create') }}" class="btn btn-primary mb-3">Add New Course</a>
                    @endrole

                    <table class="table table-striped"> 
                        <thead>
                            <tr>
                                <th>
                                    <a href="{{ route('course.index', ['sort_by' => 'course_code', 'order' => $sortBy === 'course_code' && $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                        Course Code
                                        @if($sortBy === 'course_code')
                                            <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('course.index', ['sort_by' => 'name', 'order' => $sortBy === 'name' && $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">
                                        Course Name
                                        @if($sortBy === 'name')
                                            <i class="fas fa-sort-{{ $order === 'asc' ? 'up' : 'down' }}"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Credit Hour</th>
                                <th>Classification</th>
                                <th>Prerequisites</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr class="{{ $search && (stripos($course->name, $search) !== false || stripos($course->course_code, $search) !== false) ? 'table-primary' : '' }}">
                                    <td>{{ $course->course_code }}</td>
                                    <td>{{ $course->name }}</td>
                                    <td>{{ $course->credit_hour }}</td>
                                    <td>{{ $course->classification }}</td>
                                    <td>
                                        @if($course->prerequisites->isNotEmpty())
                                            <ul>
                                                @foreach($course->prerequisites as $prerequisite)
                                                    <li>{{ $prerequisite->course_code }} - {{ $prerequisite->name }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td>{{ $course->description }}</td>
                                    <td>
                                        @role('admin|advisor|student')
                                            <a href="{{ route('course.show', $course->course_code) }}" class="btn btn-info btn-sm">View</a>
                                        @endrole
                                        @role('admin')
                                            <a href="{{ route('course.edit', $course->course_code) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('course.destroy', $course->course_code) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                            </form>
                                        @endrole
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No courses available</td>
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
