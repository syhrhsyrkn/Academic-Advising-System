@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Academic Results</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Semester</th>
                <th>Grade</th>
                <th>GPA</th>
                <th>CGPA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($academicResults as $result)
            <tr>
                <td>{{ $result->course_code }}</td>
                <td>{{ $result->course->name }}</td>
                <td>{{ $result->semester->semester_name }}</td>
                <td>{{ $result->grade }}</td>
                <td>{{ $result->gpa }}</td>
                <td>{{ $result->cgpa }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
