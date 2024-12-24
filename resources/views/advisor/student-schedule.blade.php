@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Course Schedule</h1>

    <!-- Table for Year 1 -->
    <h2 class="mt-5">Year 1</h2>
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
                            @php $totalCredit = 0; @endphp
                            <tr class="table-info font-weight-bold">
                                    <td>Code</td>
                                    <td>Name</td>
                                    <td>Chr</td>
                                </tr>
                            @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }} </td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td></td>
                                <td>{{ $totalCredit }} </td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>

    <!-- Table for Year 2 -->
    <h2 class="mt-5">Year 2</h2>
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
                @for ($sem = 4; $sem <= 6; $sem++)
                    <td>
                        <table class="table table-sm">
                            @php $totalCredit = 0; @endphp
                            <tr class="table-info font-weight-bold">
                                    <td>Code</td>
                                    <td>Name</td>
                                    <td>Chr</td>
                                </tr>
                            @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }} </td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td></td>
                                <td>{{ $totalCredit }} </td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>

    <!-- Table for Year 3 -->
    <h2 class="mt-5">Year 3</h2>
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
                @for ($sem = 7; $sem <= 9; $sem++)
                    <td>
                        <table class="table table-sm">
                            @php $totalCredit = 0; @endphp
                            <tr class="table-info font-weight-bold">
                                    <td>Code</td>
                                    <td>Name</td>
                                    <td>Chr</td>
                                </tr>
                            @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }} </td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td></td>
                                <td>{{ $totalCredit }} </td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>

    <!-- Table for Year 4 -->
    <h2 class="mt-5">Year 4</h2>
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
                @for ($sem = 10; $sem <= 12; $sem++)
                    <td>
                        <table class="table table-sm">
                            @php $totalCredit = 0; @endphp
                            <tr class="table-info font-weight-bold">
                                    <td>Code</td>
                                    <td>Name</td>
                                    <td>Chr</td>
                                </tr>
                            @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }} </td>
                                </tr>
                                @php $totalCredit += $schedule->course->credit_hour; @endphp
                            @endforeach
                            <tr class="table-info font-weight-bold">
                                <td>Total</td>
                                <td></td>
                                <td>{{ $totalCredit }} </td>
                            </tr>
                        </table>
                    </td>
                @endfor
            </tr>
        </tbody>
    </table>
</div>

@endsection
