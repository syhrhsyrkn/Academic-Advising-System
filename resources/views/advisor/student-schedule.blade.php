@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Course Schedule</h1>

    <!-- Table for Year 1 & Year 2 -->
    <h2 class="mt-5">Year 1 & Year 2</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center"><strong>Year 1 <br> Semester 1</strong></th>
                <th class="text-center"><strong>Year 1 <br> Semester 2</strong></th>
                <th class="text-center"><strong>Year 1 <br> Semester 3</strong></th>
                <th class="text-center"><strong>Year 2 <br> Semester 1</strong></th>
                <th class="text-center"><strong>Year 2 <br> Semester 2</strong></th>
                <th class="text-center"><strong>Year 2 <br> Semester 3</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @for ($sem = 1; $sem <= 6; $sem++)
                    <td>
                        <table class="table table-sm">
                            @php $totalCredit = 0; @endphp
                            @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }} chr</td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td>{{ $totalCredit }} chr</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>

    <!-- Table for Year 3 & Year 4 -->
    <h2 class="mt-5">Year 3 & Year 4</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center"><strong>Year 3 <br> Semester 1</strong></th>
                <th class="text-center"><strong>Year 3 <br> Semester 2</strong></th>
                <th class="text-center"><strong>Year 3 <br> Semester 3</strong></th>
                <th class="text-center"><strong>Year 4 <br> Semester 1</strong></th>
                <th class="text-center"><strong>Year 4 <br> Semester 2</strong></th>
                <th class="text-center"><strong>Year 4 <br> Semester 3</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @for ($sem = 7; $sem <= 12; $sem++)
                    <td>
                        <table class="table table-sm">
                            @php $totalCredit = 0; @endphp
                            @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }} chr</td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td>{{ $totalCredit }} chr</td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>
</div>

@endsection
