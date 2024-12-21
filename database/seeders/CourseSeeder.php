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
        DB::table('courses')->insert([
            // URC
            [
                'course_code' => 'UNGS 1301',
                'name' => 'Basic Philosophy and Islamic Worldview',
                'credit_hour' => 3,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'UNGS 2290',
                'name' => 'Knowledge & Civilization in Islam',
                'credit_hour' => 2,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'UNGS 2380',
                'name' => 'Ethics and Fiqh of Contemporary Issues',
                'credit_hour' => 3,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'TQTD 1002',
                'name' => 'Tilawah Al-Quran 1',
                'credit_hour' => 0.5,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'TQTD 2002',
                'name' => 'Tilawah Al-Quran 2',
                'credit_hour' => 0.5,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'CCUB 1061',
                'name' => 'Usrah I',
                'credit_hour' => 0.5,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'CCUB 1062',
                'name' => 'Usrah II',
                'credit_hour' => 0.5,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'SCSH 1201',
                'name' => 'Sustainable Development Issues, Principles and Practices',
                'credit_hour' => 2,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'SCSH 2163',
                'name' => 'Usrah in Action 1',
                'credit_hour' => 1,
                'classification' => 'URC',
                'description' => null,
            ],
            [
                'course_code' => 'SCSH 3164',
                'name' => 'Usrah in Action 2',
                'credit_hour' => 1,
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
                'course_code' => 'BIIT 1303',
                'name' => 'System Analysis and Design',
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
                'course_code' => 'BICS 1302',
                'name' => 'Introduction to Computer Organisation',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1303',
                'name' => 'Computer Networking',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            [
                'course_code' => 'BICS 2305',
                'name' => 'Operating Systems',
                'credit_hour' => 3,
                'classification' => 'CCC',
                'description' => null,
            ],
            // DCC
            [
                'course_code' => 'BIIT 1302',
                'name' => 'Organisational Informatics',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 2301',
                'name' => 'User Experience Design',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 2302',
                'name' => 'Management of Information Security',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 2303',
                'name' => 'Network Infrastructure Management',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 2305',
                'name' => 'Web Application Development',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
            [
                'course_code' => 'BICS 1304',
                'name' => 'Object-Oriented Programming',
                'credit_hour' => 3,
                'classification' => 'DCC',
                'description' => null,
            ],
            //FYP
            [
                'course_code' => 'BIIT 4321',
                'name' => 'Final Year Project I',
                'credit_hour' => 3,
                'classification' => 'FYP',
                'description' => null,
            ],
            [
                'course_code' => 'BIIT 4421',
                'name' => 'Final Year Project II',
                'credit_hour' => 4,
                'classification' => 'FYP',
                'description' => null,
            ],
            //IAP
            [
                'course_code' => 'BIIT 4901',
                'name' => 'Industrial Attachment',
                'credit_hour' => 9,
                'classification' => 'IAP',
                'description' => null,
            ],
        ]);
    }
}
