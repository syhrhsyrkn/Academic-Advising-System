@extends('layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h1>Academic Results</h1>

        <!-- Edit Button -->
        <a href="{{ route('academic-result.edit', $studentId) }}" class="btn btn-primary">Edit Results</a>
    </div>

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

        <!-- Table for Year 1 -->
        <h2 class="mt-5">Year 1</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center"><strong>Year 1 <br> Semester 1</strong></th>
                    <th class="text-center"><strong>Year 1 <br> Semester 2</strong></th>
                    <th class="text-center"><strong>Year 1 <br> Semester 3</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($sem = 1; $sem <= 3; $sem++)
                        <td>
                            <table class="table table-sm">
                                @php 
                                    $totalCredit = 0; 
                                    $totalGradePoint = 0; 
                                    $cumulativeCredit = 0; 
                                    $cumulativeGradePoint = 0; 
                                @endphp
                                <tr class="table-info font-weight-bold">
                                    <td>Code</td>
                                    <td>Name</td>
                                    <td>Chr</td>
                                    <td>Grade</td>
                                    <td>Point</td>
                                </tr>
                                @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>                                  
                                    <td>{{ $schedule->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                        <select name="grades[{{ $schedule->course_code }}]" class="form-control grade-dropdown" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            @foreach (['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'D-', 'E', 'F'] as $grade)
                                                <option value="{{ $grade }}" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" 
                                            name="points[{{ $schedule->course_code }}]" 
                                            class="form-control grade-point" 
                                            value="{{ old('points.' . $schedule->course_code, $schedule->academicResults->point ?? '') }}" 
                                            min="0" max="4" step="0.01" 
                                            placeholder="Grade Point" 
                                            readonly>
                                    </td>
                                </tr>
                                @php 
                                    $totalCredit += $schedule->course->credit_hour;
                                    $grade = $schedule->academicResults->grade ?? null;
                                    $gradePoint = $grade ? App\Models\AcademicResult::getGradePoint($grade) : 0;
                                    $totalGradePoint += $gradePoint * $schedule->course->credit_hour;
                                    $cumulativeCredit += $schedule->course->credit_hour;
                                    $cumulativeGradePoint += $gradePoint * $schedule->course->credit_hour;
                                @endphp
                                @endforeach
                                
                                <tr class="table-info font-weight-bold">
                                    <td>Total:</td>
                                    <td></td>
                                    <td>{{ $totalCredit }}</td>
                                    <td></td>
                                    <td>{{ $totalGradePoint }}</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>GPA:</td>
                                    <td class="gpa-cell">
                                        {{ $gpas[$sem] ?? 'N/A' }} &nbsp; &nbsp; &nbsp;
                                    </td>
                                    <td>CGPA:</td>
                                    <td>
                                        {{ $cgpa }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection
