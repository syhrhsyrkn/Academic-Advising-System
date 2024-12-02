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
                'course_code' => 'UNGS 1301',
                'name' => 'Basic Philosophy and Islamic Worldview',
                'credit_hour' => 3,
                'classification' => 'URC',
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
                'course_code' => 'BICS 1304',
                'name' => 'Object-Oriented Programming',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'prerequisite' => 'BICS 1301',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4330',
                'name' => 'Cyber Risk Management',
                'credit_hour' => 3,
                'classification' => 'Field Electives',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4340',
                'name' => 'Cloud Computing Services',
                'credit_hour' => 3,
                'classification' => 'Free Electives',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4321',
                'name' => 'Final Year Project I',
                'credit_hour' => 3,
                'classification' => 'FYP',
                'prerequisite' => null,
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4901',
                'name' => 'Industrial Attachment ',
                'credit_hour' => 9,
                'classification' => 'IAP',
                'prerequisite' => null,
                'description' => null,
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
