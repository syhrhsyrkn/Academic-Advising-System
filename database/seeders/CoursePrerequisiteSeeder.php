<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursePrerequisiteSeeder extends Seeder
{
    public function run()
    {
        // Fetch courses by course_code
        $courses = [
            'BICS 1303' => ['BICS 1302'], // Computer Networking requires Introduction to Computer Organisation
            'BICS 2305' => ['BICS 1302'], // Operating Systems requires Introduction to Computer Organisation
            'BICS 1304' => ['BICS 1301'], // Object-Oriented Programming requires Elements of Programming
            'BIIT 1303' => ['BICS 1301'], // System Analysis and Design requires Elements of Programming
        ];

        foreach ($courses as $courseCode => $prerequisites) {
            $course = Course::where('course_code', $courseCode)->first();

            if ($course) {
                $prerequisiteCourses = Course::whereIn('course_code', $prerequisites)->pluck('course_code');
                $course->prerequisites()->attach($prerequisiteCourses);
            }
        }
    }
}
