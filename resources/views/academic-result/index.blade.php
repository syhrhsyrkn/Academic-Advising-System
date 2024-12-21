@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Academic Results</h1>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('academic-result.store', $studentId) }}" method="POST">
        @csrf

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
                                        <td>{{ $schedule->course_code }}</td>
                                        <td>{{ $schedule->course->name }}</td>
                                        <td>{{ $schedule->course->credit_hour }}</td>

                                        <td>
                                            <input type="text" name="grades[{{ $schedule->course_code }}]" 
                                                   class="form-control" 
                                                   value="{{ old('grades.' . $schedule->course_code, $schedule->grade ?? '') }}"
                                                   placeholder="Enter grade" required
                                                   @if(!isset($isEditing)) disabled @endif>
                                        </td>

                                        <td>
                                            <input type="number" name="scores[{{ $schedule->course_code }}]" 
                                                   class="form-control" 
                                                   value="{{ old('scores.' . $schedule->course_code, $schedule->score ?? '') }}"
                                                   min="0" max="4" step="0.1" placeholder="Enter score" required
                                                   @if(!isset($isEditing)) disabled @endif>
                                        </td>
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
                                        <td>{{ $schedule->course_code }}</td>
                                        <td>{{ $schedule->course->name }}</td>
                                        <td>{{ $schedule->course->credit_hour }} </td>

                                        <td>
                                            <input type="text" name="grades[{{ $schedule->course_code }}]" 
                                                   class="form-control" 
                                                   value="{{ old('grades.' . $schedule->course_code, $schedule->grade ?? '') }}"
                                                   placeholder="Enter grade" required
                                                   @if(!isset($isEditing)) disabled @endif>
                                        </td>

                                        <td>
                                            <input type="number" name="scores[{{ $schedule->course_code }}]" 
                                                   class="form-control" 
                                                   value="{{ old('scores.' . $schedule->course_code, $schedule->score ?? '') }}"
                                                   min="0" max="4" step="0.1" placeholder="Enter score" required
                                                   @if(!isset($isEditing)) disabled @endif>
                                        </td>
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

        <!-- Buttons to update and save -->
        <div class="mt-4">
            @if(!isset($isEditing))
                <button type="button" class="btn btn-warning" onclick="toggleEdit()">Update</button>
            @else
                <button type="submit" class="btn btn-success">Save</button>
            @endif
        </div>
    </form>
</div>

<script>
    function toggleEdit() {
        @if(isset($isEditing))
            window.location.reload(); 
        @else
            window.location.search = '?edit=true';
        @endif
    }
</script>

@endsection
