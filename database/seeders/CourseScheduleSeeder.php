<?php

namespace Database\Seeders;

use App\Models\CourseSchedule;
use Illuminate\Database\Seeder;

class CourseScheduleSeeder extends Seeder
{
    public function run()
    {
        CourseSchedule::create([
            'matric_no' => '2112510', // Example matric number
            'course_code' => 'BIIT 1301', // Course 1
            'semester' => 1, // First semester
            'year' => 2024, // Current year
            'total_credit_hour' => 3, // Credit hours for this course
        ]);

        CourseSchedule::create([
            'matric_no' => '2112510', // Example matric number
            'course_code' => 'BIIT 1302', // Course 2
            'semester' => 1, // First semester
            'year' => 2024, // Current year
            'total_credit_hour' => 3, // Credit hours for this course
        ]);

        CourseSchedule::create([
            'matric_no' => '2112510', // Example matric number
            'course_code' => 'BICS 1301', // Course 3
            'semester' => 1, // First semester
            'year' => 2024, // Current year
            'total_credit_hour' => 3, // Credit hours for this course
        ]);

        CourseSchedule::create([
            'matric_no' => '2112510', // Example matric number
            'course_code' => 'BICS 1302', // Course 4
            'semester' => 1, // First semester
            'year' => 2024, // Current year
            'total_credit_hour' => 3, // Credit hours for this course
        ]);

        CourseSchedule::create([
            'matric_no' => '2112510', // Example matric number
            'course_code' => 'BICS 1303', // Course 5
            'semester' => 1, // First semester
            'year' => 2024, // Current year
            'total_credit_hour' => 3, // Credit hours for this course
        ]);

        // Total credit hours for this semester: 15
    }
}
