@extends('layouts.master')

@section('content')
<div class="container">
    <div>
        <h1>Course Schedule</h1>

        <!-- Add Course Form -->
        <form action="{{ route('student_course_schedule.store', $studentId) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="semester_id">Select Semester:</label>
                <select name="semester_id" id="semester_id" class="form-control" required>
                    <option value="" disabled selected>Select Semester ...</option>
                    @foreach($semesters as $semester)
                        <option value="{{ $semester->id }}">
                            {{ $semester->academicYear->year_name }} ( {{ $semester->semester_name }} )
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="course_code">Select Course:</label>
                <select name="course_code" id="course_code" class="form-control" required>
                    @foreach($courses as $course)
                        @if(!in_array($course->course_code, $existingCourses)) <!-- Only show courses not in schedule -->
                            <option value="{{ $course->course_code }}">
                                {{ $course->course_code }} - {{ $course->name }} ({{ $course->credit_hour }} chr )
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add to Schedule</button>
        </form>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>


    @foreach ([1, 2, 3, 4] as $year)
    <h2 class="mt-5">Year {{ $year }}</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Semester 1</th>
                <th class="text-center">Semester 2</th>
                <th class="text-center">Semester 3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @for ($sem = ($year - 1) * 3 + 1; $sem <= $year * 3; $sem++)
                    <td>
                        <table class="table table-sm">
                            @php $totalCredit = 0; @endphp
                            <tr class="table-info font-weight-bold">
                                <td>Code</td>
                                <td>Name</td>
                                <td>Chr</td>
                                <td>Action</td>
                            </tr>
                            @foreach ($semesterSchedules[$sem] as $schedule)
                                <tr>
                                    <td class="text-center">{{ $schedule->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td></td>
                                <td>{{ $totalCredit }}</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>
@endforeach

</div>
@endsection
