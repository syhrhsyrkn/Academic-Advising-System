<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    public function run()
    {
        $academicYears = [
            ['year_name' => 'Year 1'],
            ['year_name' => 'Year 2'],
            ['year_name' => 'Year 3'],
            ['year_name' => 'Year 4'],
        ];

        DB::table('academic_years')->insert($academicYears);
    }
}
