@extends('layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mt-3">
        <h1>Edit Academic Results</h1>
        <a href="{{ route('academic-result.index', $studentId) }}" class="btn btn-secondary">Cancel</a>
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

    <form action="{{ route('academic-result.update', $studentId) }}" method="POST">
        @csrf
        @method('PUT')

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

                                    <td>
                                        <select name="grades[{{ $schedule->course_code }}]" class="form-control grade-dropdown" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            <option value="A" {{ $academicResult && $academicResult->grade == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="A-" {{ $academicResult && $academicResult->grade == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ $academicResult && $academicResult->grade == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B" {{ $academicResult && $academicResult->grade == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="B-" {{ $academicResult && $academicResult->grade == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="C+" {{ $academicResult && $academicResult->grade == 'C+' ? 'selected' : '' }}>C+</option>
                                            <option value="C" {{ $academicResult && $academicResult->grade == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $academicResult && $academicResult->grade == 'D' ? 'selected' : '' }}>D</option>
                                            <option value="E" {{ $academicResult && $academicResult->grade == 'E' ? 'selected' : '' }}>E</option>
                                            <option value="F" {{ $academicResult && $academicResult->grade == 'F' ? 'selected' : '' }}>F</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" class="form-control grade-point" value="{{ $academicResult ? $academicResult->point : '' }}" readonly>
                                    </td>
                                    </tr>
                                @endforeach
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

                                    <td>
                                        <select name="grades[{{ $schedule->course_code }}]" class="form-control grade-dropdown" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            <option value="A" {{ $academicResult && $academicResult->grade == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="A-" {{ $academicResult && $academicResult->grade == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ $academicResult && $academicResult->grade == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B" {{ $academicResult && $academicResult->grade == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="B-" {{ $academicResult && $academicResult->grade == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="C+" {{ $academicResult && $academicResult->grade == 'C+' ? 'selected' : '' }}>C+</option>
                                            <option value="C" {{ $academicResult && $academicResult->grade == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $academicResult && $academicResult->grade == 'D' ? 'selected' : '' }}>D</option>
                                            <option value="E" {{ $academicResult && $academicResult->grade == 'E' ? 'selected' : '' }}>E</option>
                                            <option value="F" {{ $academicResult && $academicResult->grade == 'F' ? 'selected' : '' }}>F</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" class="form-control grade-point" value="{{ $academicResult ? $academicResult->point : '' }}" readonly>
                                    </td>
                                    </tr>
                                @endforeach
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

                                    <td>
                                        <select name="grades[{{ $schedule->course_code }}]" class="form-control grade-dropdown" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            <option value="A" {{ $academicResult && $academicResult->grade == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="A-" {{ $academicResult && $academicResult->grade == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ $academicResult && $academicResult->grade == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B" {{ $academicResult && $academicResult->grade == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="B-" {{ $academicResult && $academicResult->grade == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="C+" {{ $academicResult && $academicResult->grade == 'C+' ? 'selected' : '' }}>C+</option>
                                            <option value="C" {{ $academicResult && $academicResult->grade == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $academicResult && $academicResult->grade == 'D' ? 'selected' : '' }}>D</option>
                                            <option value="E" {{ $academicResult && $academicResult->grade == 'E' ? 'selected' : '' }}>E</option>
                                            <option value="F" {{ $academicResult && $academicResult->grade == 'F' ? 'selected' : '' }}>F</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" class="form-control grade-point" value="{{ $academicResult ? $academicResult->point : '' }}" readonly>
                                    </td>
                                    </tr>
                                @endforeach
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

                                    <td>
                                        <select name="grades[{{ $schedule->course_code }}]" class="form-control grade-dropdown" required>
                                            <option value="" disabled selected>Select Grade</option>
                                            <option value="A" {{ $academicResult && $academicResult->grade == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="A-" {{ $academicResult && $academicResult->grade == 'A-' ? 'selected' : '' }}>A-</option>
                                            <option value="B+" {{ $academicResult && $academicResult->grade == 'B+' ? 'selected' : '' }}>B+</option>
                                            <option value="B" {{ $academicResult && $academicResult->grade == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="B-" {{ $academicResult && $academicResult->grade == 'B-' ? 'selected' : '' }}>B-</option>
                                            <option value="C+" {{ $academicResult && $academicResult->grade == 'C+' ? 'selected' : '' }}>C+</option>
                                            <option value="C" {{ $academicResult && $academicResult->grade == 'C' ? 'selected' : '' }}>C</option>
                                            <option value="D" {{ $academicResult && $academicResult->grade == 'D' ? 'selected' : '' }}>D</option>
                                            <option value="E" {{ $academicResult && $academicResult->grade == 'E' ? 'selected' : '' }}>E</option>
                                            <option value="F" {{ $academicResult && $academicResult->grade == 'F' ? 'selected' : '' }}>F</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="points[{{ $schedule->course_code }}]" class="form-control grade-point" value="{{ $academicResult ? $academicResult->point : '' }}" readonly>
                                    </td>
                                    </tr>
                                @endforeach
                            </table>
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>

        <input type="hidden" name="semester_id" value="{{ $semesterId }}">

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
    </form>
</div>

<script>
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

        // Update grade points and GPA dynamically
        document.querySelectorAll('.grade-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function () {
                const selectedGrade = this.value;
                const pointField = this.closest('tr').querySelector('.grade-point');
                pointField.value = gradeToPoint[selectedGrade] || '';
                updateGPA();
            });
        });

        function updateGPA() {
            let cumulativeCredit = 0;
            let cumulativeGradePoint = 0;

            document.querySelectorAll('table.table-sm').forEach((table) => {
                let totalCredit = 0;
                let totalGradePoint = 0;

                table.querySelectorAll('tr').forEach((row) => {
                    const creditCell = row.querySelector('td:nth-child(3)');
                    const pointField = row.querySelector('.grade-point');

                    if (creditCell && pointField) {
                        const creditHour = parseFloat(creditCell.textContent.trim()) || 0;
                        const gradePoint = parseFloat(pointField.value) || 0;

                        totalCredit += creditHour;
                        totalGradePoint += creditHour * gradePoint;
                        cumulativeCredit += creditHour;
                        cumulativeGradePoint += creditHour * gradePoint;
                    }
                });

                const totalGradePointCell = table.querySelector('.total-grade-point');
                if (totalGradePointCell) {
                    totalGradePointCell.textContent = totalGradePoint.toFixed(2);
                }

                const gpaCell = table.querySelector('.gpa-value');
                if (gpaCell) {
                    gpaCell.textContent = totalCredit > 0 ? (totalGradePoint / totalCredit).toFixed(2) : '0.00';
                }
            });

            const cgpaElement = document.getElementById('cgpa');
            if (cgpaElement) {
                cgpaElement.textContent = cumulativeCredit > 0 ? (cumulativeGradePoint / cumulativeCredit).toFixed(2) : '0.00';
            }
        }
    });
</script>
@endsection
