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
                                    @php
                                        // Construct the key based on course_code and semester_id
                                        $academicResultKey = $schedule->course_code . '-' . $sem;
                                        $academicResult = $academicResults->get($academicResultKey);
                                    @endphp

                                    <td>{{ $academicResult ? $academicResult->grade : 'N/A' }}</td> <!-- Display grade -->
                                    <td>{{ $academicResult ? $academicResult->point : 'N/A' }}</td> <!-- Display point -->

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
                                    @php
                                        // Construct the key based on course_code and semester_id
                                        $academicResultKey = $schedule->course_code . '-' . $sem;
                                        $academicResult = $academicResults->get($academicResultKey);
                                    @endphp

                                    <td>{{ $academicResult ? $academicResult->grade : 'N/A' }}</td> <!-- Display grade -->
                                    <td>{{ $academicResult ? $academicResult->point : 'N/A' }}</td> <!-- Display point -->

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
                                    @php
                                        // Construct the key based on course_code and semester_id
                                        $academicResultKey = $schedule->course_code . '-' . $sem;
                                        $academicResult = $academicResults->get($academicResultKey);
                                    @endphp

                                    <td>{{ $academicResult ? $academicResult->grade : 'N/A' }}</td> <!-- Display grade -->
                                    <td>{{ $academicResult ? $academicResult->point : 'N/A' }}</td> <!-- Display point -->

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
                                    @php
                                        // Construct the key based on course_code and semester_id
                                        $academicResultKey = $schedule->course_code . '-' . $sem;
                                        $academicResult = $academicResults->get($academicResultKey);
                                    @endphp

                                    <td>{{ $academicResult ? $academicResult->grade : 'N/A' }}</td> <!-- Display grade -->
                                    <td>{{ $academicResult ? $academicResult->point : 'N/A' }}</td> <!-- Display point -->

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

<script>
    function toggleEdit() {
        @if(isset($isEditing))
            window.location.reload();
        @else
            window.location.search = '?edit=true';
        @endif
    }

    document.addEventListener('DOMContentLoaded', function () {
        const gradeToPoint = {
            'A': 4.00,
            'A-': 3.67,
            'B+': 3.33,
            'B': 3.00,
            'B-': 2.67,
            'C+': 2.33,
            'C': 2.00,
            'D': 1.67,
            'D-': 1.33,
            'E': 1.00,
            'F': 0.00,
        };

        // Update grade points when a grade is selected
        document.querySelectorAll('.grade-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                const selectedGrade = this.value;
                const pointField = this.closest('tr').querySelector('.grade-point');
                pointField.value = gradeToPoint[selectedGrade] || '';
                updateGPA(); // Recalculate GPA after a grade change
            });
        });

        // Function to calculate and update GPA
        function updateGPA() {
            document.querySelectorAll('table.table-sm').forEach((table) => {
                let totalCredit = 0;
                let totalGradePoint = 0;

                // Iterate through each row of the table
                table.querySelectorAll('tr').forEach((row) => {
                    const creditCell = row.querySelector('td:nth-child(3)');
                    const pointField = row.querySelector('.grade-point');

                    // Make sure the row contains valid credit and point values
                    if (creditCell && pointField) {
                        const creditHour = parseFloat(creditCell.textContent.trim()) || 0;
                        const gradePoint = parseFloat(pointField.value) || 0;

                        totalCredit += creditHour;
                        totalGradePoint += creditHour * gradePoint;
                    }
                });

                // Find the GPA row and update the GPA value
                const gpaRow = table.querySelector('tr.table-info');
                const gpaCell = gpaRow ? gpaRow.querySelector('td:last-child') : null;
                const gpa = totalCredit > 0 ? (totalGradePoint / totalCredit).toFixed(2) : '0.00';

                if (gpaCell) {
                    gpaCell.textContent = `GPA: ${gpa}`;
                }
            });
        }
    });
</script>

@endsection
