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
                                @php $totalCredit = 0; $totalGradePoint = 0; @endphp
                                @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>

                                    <td>
                                    <select name="grades[{{ $schedule->course_code }}]" class="form-control" required
                                            @if(!isset($isEditing) || !$isEditing) disabled @endif>
                                        <option value="" disabled selected>Select Grade</option>
                                        <option value="A" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="A-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="B-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="C+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C+' ? 'selected' : '' }}>C+</option>
                                        <option value="C" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D' ? 'selected' : '' }}>D</option>
                                        <option value="D-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D-' ? 'selected' : '' }}>D-</option>
                                        <option value="E" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="F" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'F' ? 'selected' : '' }}>F</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" 
                                            class="form-control" 
                                            value="{{ old('points.' . $schedule->course_code, App\Models\AcademicResult::getGradePoint($schedule->grade) ?? '') }}"
                                            min="0" max="4" step="0.01" placeholder="Grade Point" readonly>
                                    </td>
                                </tr>

                                    @php 
                                        $totalCredit += $schedule->course->credit_hour;
                                        $gradePoint = App\Models\AcademicResult::getGradePoint($schedule->grade);
                                        $totalGradePoint += $gradePoint * $schedule->course->credit_hour;
                                    @endphp
                                @endforeach
                                <tr class="table-info font-weight-bold">
                                    <td>Total</td>
                                    <td>{{ $totalCredit }} chr</td>
                                    <td>{{ $totalGradePoint }} grade points</td>
                                    <td>GPA: 
                                        @php
                                            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
                                        @endphp
                                        {{ $gpa }}
                                    </td>
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
                    <th class="text-center"><strong>Year 2 <br> Semester 1</strong></th>
                    <th class="text-center"><strong>Year 2 <br> Semester 2</strong></th>
                    <th class="text-center"><strong>Year 2 <br> Semester 3</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($sem = 4; $sem <= 6; $sem++)
                        <td>
                            <table class="table table-sm">
                                @php $totalCredit = 0; $totalGradePoint = 0; @endphp
                                @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                    <select name="grades[{{ $schedule->course_code }}]" class="form-control" required
                                            @if(!isset($isEditing) || !$isEditing) disabled @endif>
                                        <option value="" disabled selected>Select Grade</option>
                                        <option value="A" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="A-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="B-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="C+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C+' ? 'selected' : '' }}>C+</option>
                                        <option value="C" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D' ? 'selected' : '' }}>D</option>
                                        <option value="D-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D-' ? 'selected' : '' }}>D-</option>
                                        <option value="E" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="F" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'F' ? 'selected' : '' }}>F</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" 
                                            class="form-control" 
                                            value="{{ old('points.' . $schedule->course_code, App\Models\AcademicResult::getGradePoint($schedule->grade) ?? '') }}"
                                            min="0" max="4" step="0.01" placeholder="Grade Point" readonly>
                                    </td>
                                </tr>
                                    @php 
                                        $totalCredit += $schedule->course->credit_hour;
                                        $gradePoint = App\Models\AcademicResult::getGradePoint($schedule->grade);
                                        $totalGradePoint += $gradePoint * $schedule->course->credit_hour;
                                    @endphp
                                @endforeach
                                <tr class="table-info font-weight-bold">
                                    <td>Total</td>
                                    <td>{{ $totalCredit }} chr</td>
                                    <td>{{ $totalGradePoint }} grade points</td>
                                    <td>GPA: 
                                        @php
                                            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
                                        @endphp
                                        {{ $gpa }}
                                    </td>
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
                    <th class="text-center"><strong>Year 3 <br> Semester 1</strong></th>
                    <th class="text-center"><strong>Year 3 <br> Semester 2</strong></th>
                    <th class="text-center"><strong>Year 3 <br> Semester 3</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($sem = 7; $sem <= 9; $sem++)
                        <td>
                            <table class="table table-sm">
                                @php $totalCredit = 0; $totalGradePoint = 0; @endphp
                                @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                    <select name="grades[{{ $schedule->course_code }}]" class="form-control" required
                                            @if(!isset($isEditing) || !$isEditing) disabled @endif>
                                        <option value="" disabled selected>Select Grade</option>
                                        <option value="A" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="A-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="B-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="C+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C+' ? 'selected' : '' }}>C+</option>
                                        <option value="C" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D' ? 'selected' : '' }}>D</option>
                                        <option value="D-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D-' ? 'selected' : '' }}>D-</option>
                                        <option value="E" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="F" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'F' ? 'selected' : '' }}>F</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" 
                                            class="form-control" 
                                            value="{{ old('points.' . $schedule->course_code, App\Models\AcademicResult::getGradePoint($schedule->grade) ?? '') }}"
                                            min="0" max="4" step="0.01" placeholder="Grade Point" readonly>
                                    </td>
                                </tr>

                                    @php 
                                        $totalCredit += $schedule->course->credit_hour;
                                        $gradePoint = App\Models\AcademicResult::getGradePoint($schedule->grade);
                                        $totalGradePoint += $gradePoint * $schedule->course->credit_hour;
                                    @endphp
                                @endforeach
                                <tr class="table-info font-weight-bold">
                                    <td>Total</td>
                                    <td>{{ $totalCredit }} chr</td>
                                    <td>{{ $totalGradePoint }} grade points</td>
                                    <td>GPA: 
                                        @php
                                            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
                                        @endphp
                                        {{ $gpa }}
                                    </td>
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
                    <th class="text-center"><strong>Year 4 <br> Semester 1</strong></th>
                    <th class="text-center"><strong>Year 4 <br> Semester 2</strong></th>
                    <th class="text-center"><strong>Year 4 <br> Semester 3</strong></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($sem = 10; $sem <= 12; $sem++)
                        <td>
                            <table class="table table-sm">
                                @php $totalCredit = 0; $totalGradePoint = 0; @endphp
                                @foreach ($semesterSchedules[$sem] ?? [] as $schedule)
                                <tr>
                                    <td>{{ $schedule->course_code }}</td>
                                    <td>{{ $schedule->course->name }}</td>
                                    <td>{{ $schedule->course->credit_hour }}</td>
                                    <td>
                                    <select name="grades[{{ $schedule->course_code }}]" class="form-control" required
                                            @if(!isset($isEditing) || !$isEditing) disabled @endif>
                                        <option value="" disabled selected>Select Grade</option>
                                        <option value="A" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="A-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="B-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="C+" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C+' ? 'selected' : '' }}>C+</option>
                                        <option value="C" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'C' ? 'selected' : '' }}>C</option>
                                        <option value="D" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D' ? 'selected' : '' }}>D</option>
                                        <option value="D-" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'D-' ? 'selected' : '' }}>D-</option>
                                        <option value="E" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'E' ? 'selected' : '' }}>E</option>
                                        <option value="F" {{ old('grades.' . $schedule->course_code, $schedule->academicResults->grade ?? '') == 'F' ? 'selected' : '' }}>F</option>
                                    </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" 
                                            class="form-control" 
                                            value="{{ old('points.' . $schedule->course_code, App\Models\AcademicResult::getGradePoint($schedule->grade) ?? '') }}"
                                            min="0" max="4" step="0.01" placeholder="Grade Point" readonly>
                                    </td>
                                </tr>
                                    @php 
                                        $totalCredit += $schedule->course->credit_hour;
                                        $gradePoint = App\Models\AcademicResult::getGradePoint($schedule->grade);
                                        $totalGradePoint += $gradePoint * $schedule->course->credit_hour;
                                    @endphp
                                @endforeach
                                <tr class="table-info font-weight-bold">
                                    <td>Total</td>
                                    <td>{{ $totalCredit }} chr</td>
                                    <td>{{ $totalGradePoint }} grade points</td>
                                    <td>GPA: 
                                        @php
                                            $gpa = $totalCredit > 0 ? round($totalGradePoint / $totalCredit, 2) : 0;
                                        @endphp
                                        {{ $gpa }}
                                    </td>
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
