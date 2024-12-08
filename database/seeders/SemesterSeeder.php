<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{

    public function run()
    {
        DB::table('semesters')->insert([
            [
                'semester_number' => 1,
                'academic_year' => 1,
            ],
            [
                'semester_number' => 2,
                'academic_year' => 1,
            ],
            [
                'semester_number' => 1,
                'academic_year' => 2,
            ],
            [
                'semester_number' => 2,
                'academic_year' => 2,
            ],
            [
                'semester_number' => 3,
                'academic_year' => 2, 
            ],
            [
                'semester_number' => 1,
                'academic_year' => 3,
            ],
            [
                'semester_number' => 2,
                'academic_year' => 3,
            ],
            [
                'semester_number' => 1,
                'academic_year' => 4,
            ],
            [
                'semester_number' => 2,
                'academic_year' => 4,
            ],
        ]);
    }
}
