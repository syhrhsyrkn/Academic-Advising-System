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
            //URC
            [
                'course_code' => 'UNGS 1301',
                'name' => 'Basic Philosophy and Islamic Worldview',
                'credit_hour' => 3,
                'classification' => 'URC',
                'prerequisite' => null,
                'description' => null,
            ],
            //CCC
            [
                'course_code' => 'BIIT 1301',
                'name' => 'Database Programming',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 1303',
                'name' => 'System Analysis and Design',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => 'BICS 1301',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 3304',
                'name' => 'ICT and Islam',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1301',
                'name' => 'Elements of Programming',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1302',
                'name' => 'Introduction to Computer Organisation',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1303',
                'name' => 'Computer Networking',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => 'BICS 1302',
                'description' => null,
            ],
            [
                'course_code' => 'BICS 2305',
                'name' => 'Operating Systems',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => 'BICS 1302',
                'description' => null,
            ],
            //DCS
            [
                'course_code' => 'BICS 1304',
                'name' => 'Object-Oriented Programming',
                'credit_hour' => 3,
                'classification' => 'DCS',
                'prerequisite' => 'BICS 1301',
                'description' => null,
            ],
        ];

        foreach ($courses as $courseData) {
            // Create the course
            $course = Course::create([
                'course_code' => $courseData['course_code'],
                'name' => $courseData['name'],
                'credit_hour' => $courseData['credit_hour'],
                'classification' => $courseData['classification'],
                'description' => $courseData['description'],
            ]);

            // Attach prerequisite if exists
            if ($courseData['prerequisite']) {
                $prerequisite = Course::where('course_code', $courseData['prerequisite'])->first();
                if ($prerequisite) {
                    $course->prerequisites()->attach($prerequisite->course_code); // Attach prerequisite to the course
                }
            }
        }
    }
}
