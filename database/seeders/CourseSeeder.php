<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // URC
            [
                'course_code' => 'UNGS 1301',
                'name' => 'Basic Philosophy and Islamic Worldview',
                'credit_hour' => 3,
                'classification' => 'URC',
                'description' => null,
            ],
            // CCC
            [
                'course_code' => 'BIIT 1301',
                'name' => 'Database Programming',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 3304',
                'name' => 'ICT and Islam',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1301',
                'name' => 'Elements of Programming',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 1303',
                'name' => 'System Analysis and Design',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1304',
                'name' => 'Object-Oriented Programming',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4340',
                'name' => 'Cloud Computing Services',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4321',
                'name' => 'Final Year Project I',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            // DCC
            [
                'course_code' => 'BICS 1304',
                'name' => 'Object-Oriented Programming',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
        ];

        // Insert courses into the `courses` table
        DB::table('courses')->insert($courses);

        // Insert prerequisites into the `prerequisites` table
        DB::table('prerequisites')->insert([
            ['course_code' => 'BIIT 1303', 'prerequisite_code' => 'BICS 1301'],
            ['course_code' => 'BICS 1304', 'prerequisite_code' => 'BICS 1301'],
            ['course_code' => 'BICS 1303', 'prerequisite_code' => 'BICS 1302'],
            ['course_code' => 'BICS 2305', 'prerequisite_code' => 'BICS 1302'],
        ]);
    }
}
