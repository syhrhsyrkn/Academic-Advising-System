@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Course Schedule</h1>

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
                <option value="{{ $course->course_code }}">{{ $course->course_code }} - {{ $course->name }} ({{ $course->credit_hour }} chr)</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add to Schedule</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Current Schedule</h2>

    <!-- Course Schedule Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" class="text-center"><strong>Year 1</strong></th>
                <th colspan="2" class="text-center"><strong>Year 2</strong></th>
                <th colspan="2" class="text-center"><strong>Year 3</strong></th>
                <th colspan="2" class="text-center"><strong>Year 4</strong></th>
            </tr>
            <tr>
                <th class="text-center"><strong>Semester 1</strong></th>
                <th class="text-center"><strong>Semester 2</strong></th>
                <th class="text-center"><strong>Semester 1</strong></th>
                <th class="text-center"><strong>Semester 2</strong></th>
                <th class="text-center"><strong>Semester 1</strong></th>
                <th class="text-center"><strong>Semester 2</strong></th>
                <th class="text-center"><strong>Semester 1</strong></th>
                <th class="text-center"><strong>Semester 2</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- Year 1 Semester 1 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year1Semester1Total = 0; @endphp
                        @foreach ($semesterSchedules[1] as $schedule)
                            @if($schedule->semester_id == 1)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year1Semester1Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year1Semester1Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 1 Semester 2 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year1Semester2Total = 0; @endphp
                        @foreach ($semesterSchedules[2] as $schedule)

                            @if($schedule->semester_id == 2)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year1Semester2Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year1Semester2Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 2 Semester 1 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year2Semester1Total = 0; @endphp
                        @foreach ($semesterSchedules[4] as $schedule)
                            @if($schedule->semester_id == 4)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year2Semester1Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year2Semester1Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 2 Semester 2 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year2Semester2Total = 0; @endphp
                        @foreach ($semesterSchedules[5] as $schedule)
                            @if($schedule->semester_id == 5)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year2Semester2Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year2Semester2Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 3 Semester 1 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year3Semester1Total = 0; @endphp
                        @foreach ($semesterSchedules[7] as $schedule)
                            @if($schedule->semester_id == 7)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year3Semester1Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year3Semester1Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 3 Semester 2 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year3Semester2Total = 0; @endphp
                        @foreach ($semesterSchedules[8] as $schedule)
                            @if($schedule->semester_id == 8)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year3Semester2Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year3Semester2Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 4 Semester 1 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year4Semester1Total = 0; @endphp
                        @foreach ($semesterSchedules[10] as $schedule)
                            @if($schedule->semester_id == 10)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year4Semester1Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year4Semester1Total }}</td>
                        </tr>
                    </table>
                </td>

                <!-- Year 4 Semester 2 Courses -->
                <td>
                    <table class="table table-sm">
                        @php $year4Semester2Total = 0; @endphp
                        @foreach ($semesterSchedules[11] as $schedule)
                            @if($schedule->semester_id == 11)
                                <tr>
                                    <td>{{ $schedule->course_code }} - {{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <form action="{{ route('student_course_schedule.destroy', [$studentId, $schedule->course_code, $schedule->semester_id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $year4Semester2Total += $schedule->course->credit_hour; @endphp
                            @endif
                        @endforeach
                        <tr class="table-info font-weight-bold">
                            <td>Total</td>
                            <td>{{ $year4Semester2Total }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
