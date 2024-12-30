@extends('layouts.master')

@section('content')
<div class="container">
    <!-- Display no results message if empty -->
    @if ($semesterSchedules->isEmpty())
        <p>No academic results found for this student.</p>
    @else
        @for ($year = 1; $year <= 4; $year++)
            <h2 class="text-center"><strong>Year {{ $year }}</strong></h2>
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
                        @for ($sem = 1; $sem <= 3; $sem++)
                            <td>
                                <table class="table table-sm">
                                    <thead>
                                        <tr class="table-info font-weight-bold">
                                            <td>Code</td>
                                            <td>Name</td>
                                            <td>Chr</td>
                                            <td>Grade</td>
                                            <td>Point</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $totalCredit = 0; 
                                            $totalGradePoint = 0; 
                                        @endphp
                                        @foreach ($semesterSchedules[$sem + (($year - 1) * 3)] ?? [] as $schedule)
                                            <tr>
                                                <td>{{ $schedule->course_code }}</td>
                                                <td>{{ $schedule->course->name }}</td>
                                                <td>{{ $schedule->course->credit_hour }}</td>
                                                <td>{{ $schedule->academicResults ? $schedule->academicResults->grade : '-' }}</td>
                                                <td>{{ $schedule->academicResults ? $schedule->academicResults->point : '-' }}</td>
                                            </tr>
                                            @php 
                                                $totalCredit += $schedule->course->credit_hour;
                                                $totalGradePoint += ($schedule->academicResults->point ?? 0) * $schedule->course->credit_hour;
                                            @endphp
                                        @endforeach
                                        @if ($totalCredit > 0)
                                            <tr class="table-info font-weight-bold">
                                                <td>Total:</td>
                                                <td></td>
                                                <td>{{ $totalCredit }}</td>
                                                <td></td>
                                                <td>{{ $totalGradePoint }}</td>
                                            </tr>
                                            <tr>
                                                <td>GPA:</td>
                                                <td>
                                                    {{ round($totalGradePoint / $totalCredit, 2) }}
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">No results for this semester</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        @endfor
    @endif
</div>
@endsection
