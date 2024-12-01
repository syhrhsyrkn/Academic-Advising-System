<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'course_code' => 'CS101',
                'name' => 'Introduction to Programming',
                'credit_hour' => 3,
                'classification' => 'KRC',
                'prerequisite' => null,
                'description' => 'This course introduces the basics of programming.',
            ],
            [
                'course_code' => 'CS202',
                'name' => 'Database Management Systems',
                'credit_hour' => 3,
                'classification' => 'DRC',
                'prerequisite' => 'CS101',
                'description' => 'This course covers database design and management.',
            ],
            [
                'course_code' => 'UNI101',
                'name' => 'Islamic Worldview',
                'credit_hour' => 2,
                'classification' => 'unicore',
                'prerequisite' => null,
                'description' => 'A course on understanding the Islamic perspective.',
            ],
            [
                'course_code' => 'CS301',
                'name' => 'Artificial Intelligence',
                'credit_hour' => 3,
                'classification' => 'DS',
                'prerequisite' => 'CS202',
                'description' => 'This course introduces AI concepts and techniques.',
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
