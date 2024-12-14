<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesters = [
            // Year 1
            ['semester_name' => 'Semester 1', 'academic_year_id' => 1],
            ['semester_name' => 'Semester 2', 'academic_year_id' => 1],
            ['semester_name' => 'Semester 3', 'academic_year_id' => 1],

            // Year 2
            ['semester_name' => 'Semester 1', 'academic_year_id' => 2],
            ['semester_name' => 'Semester 2', 'academic_year_id' => 2],
            ['semester_name' => 'Semester 3', 'academic_year_id' => 2],

            // Year 3
            ['semester_name' => 'Semester 1', 'academic_year_id' => 3],
            ['semester_name' => 'Semester 2', 'academic_year_id' => 3],
            ['semester_name' => 'Semester 3', 'academic_year_id' => 3],

            // Year 4
            ['semester_name' => 'Semester 1', 'academic_year_id' => 4],
            ['semester_name' => 'Semester 2', 'academic_year_id' => 4],
            ['semester_name' => 'Semester 3', 'academic_year_id' => 4],
        ];

        DB::table('semesters')->insert($semesters);
    }
}
