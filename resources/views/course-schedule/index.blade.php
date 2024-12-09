@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Course Schedule</h1>
    <div class="course-schedule-container">
        <!-- List of Courses -->
        <div class="course-list-container">
            <h3>List of Courses</h3>
            <ul id="course-list" class="sortable-list">
                @foreach($coursesByClassification as $classification => $courses)
                    <li class="classification">{{ $classification }}</li>
                    @foreach($courses as $course)
                        <li data-course-code="{{ $course->course_code }}">
                            {{ $course->name }} ({{ $course->credit_hour }} credits)
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>

        <!-- Schedule (Years and Semesters) -->
        <div class="year-container">
            @foreach ($schedules as $year => $semesters)
                <h3>{{ $year }}</h3>
                @foreach ($semesters as $semesterNumber => $courses)
                    <div class="semester-container">
                        <h4>Semester {{ $semesterNumber }}</h4>
                        <ul id="semester-{{ $year }}-{{ $semesterNumber }}" class="sortable-list semester-list">
                            @foreach ($courses as $course)
                                <li data-course-code="{{ $course->course->course_code }}">
                                    {{ $course->course->name }} ({{ $course->course->credit_hour }} credits)
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <!-- Save Button -->
    <div class="buttons">
        <button id="save-schedule" class="btn btn-primary">Save Schedule</button>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize sortable lists
        const courseList = document.getElementById('course-list');
        const semesterLists = document.querySelectorAll('.semester-list');

        // Enable drag-and-drop for course list and semesters
        new Sortable(courseList, { group: 'shared', animation: 150 });
        semesterLists.forEach(list => {
            new Sortable(list, { group: 'shared', animation: 150 });
        });

        // Save button functionality
        document.getElementById('save-schedule').addEventListener('click', function () {
            const scheduleData = {};

            semesterLists.forEach(list => {
                const semesterId = list.id;
                scheduleData[semesterId] = Array.from(list.children).map(item => item.dataset.courseCode);
            });

            // Send data to server via AJAX
            fetch('{{ route('course-schedule.saveSchedule') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify(scheduleData),
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
            })
            .catch(error => {
                console.error('Error saving schedule:', error);
            });
        });
    });
</script>
@endsection
