<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterGpaSeeder extends Seeder
{
    public function run()
    {
        $results = DB::table('academic_results')
            ->select('student_id', 'semester_id', DB::raw('AVG(gpa) as gpa'))
            ->groupBy('student_id', 'semester_id')
            ->get();

        foreach ($results as $result) {
            DB::table('semester_gpas')->insert([
                'student_id' => $result->student_id,
                'semester_id' => $result->semester_id,
                'gpa' => number_format($result->gpa, 2), 
            ]);
        }
    }
}
