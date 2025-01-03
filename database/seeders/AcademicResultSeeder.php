<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicResultSeeder extends Seeder
{
    public function run()
    {
        DB::table('academic_results')->insert([
            // Results for student A
            [
                'student_id' => 1,
                'course_code' => 'BIIT 1301',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BIIT 1302',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BICS 1301',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BICS 1302',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'UNGS 1301',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'TQTD 1002',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'CCUB 1061',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'SCSH 1201',
                'semester_id' => 1,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BIIT 1303',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BICS 1303',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BICS 1304',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'BICS 1305',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'UNGS 2380',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'TQTD 2002',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
            [
                'student_id' => 1,
                'course_code' => 'CCUB 1062',
                'semester_id' => 2,
                'grade' => 'A',
                'point' => 4.00,
            ],
        ]);
    }
}
