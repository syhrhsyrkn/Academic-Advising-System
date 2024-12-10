@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Students</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>
                    <a href="{{ route('advisor.student.profile', $student->id) }}" class="btn btn-info">View Profile</a>
                    <a href="{{ route('advisor.student.schedule', $student->id) }}" class="btn btn-primary">View Schedule</a>
                    <a href="{{ route('advisor.student.results', $student->id) }}" class="btn btn-success">View Results</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
