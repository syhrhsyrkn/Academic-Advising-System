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
                                @php 
                                    $totalCredit = 0; 
                                    $totalGradePoint = 0; 
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
                                    <select name="grades[{{ (string) $schedule->course_code }}]" class="form-control grade-dropdown" required>
                                        <option value="" disabled selected>Select Grade</option>
                                        @foreach (['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'D-', 'E', 'F'] as $grade)
                                            <option value="{{ $grade }}" {{ old('grades.' . (string) $schedule->course_code, $schedule->academicResults->grade ?? '') == $grade ? 'selected' : '' }}>
                                                {{ $grade }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </td>
                                    <td>
                                    <input type="number" 
                                    name="points[{{ (string) $schedule->course_code }}]" 
                                    class="form-control grade-point" 
                                    value="{{ old('points.' . (string) $schedule->course_code, $schedule->academicResults->point ?? '') }}" 
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
                                @endphp
                                @endforeach

                                <tr class="table-info font-weight-bold">
                                    <td>Total:</td>
                                    <td></td>
                                    <td>{{ $totalCredit }}</td>
                                    <td></td>
                                    <td class="total-grade-point">{{ $totalGradePoint }}</td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>GPA:</td>
                                    <td class="gpa-cell">
                                        <span class="gpa-value">{{ $gpas[$sem] ?? 'N/A' }}</span>
                                    </td>
                                    <td>CGPA:</td>
                                    <td>
                                        <span id="cgpa">{{ $cgpa }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    @endfor
                </tr>
            </tbody>
        </table>
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
