<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrerequisiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prerequisites')->insert([
            //URC
            ['course_code' => 'TQTD 2002', 'prerequisite_code' => 'TQTD 1002'], //Tilawah Al-Quran 2
            ['course_code' => 'CCUB 1062', 'prerequisite_code' => 'CCUB 1061'], // Usrah 2
            ['course_code' => 'SCSH 2163', 'prerequisite_code' => 'SCSH 1201'], //UIA 1
            ['course_code' => 'SCSH 3164', 'prerequisite_code' => 'SCSH 2163'], //UIA 2
            //CCC
            ['course_code' => 'BIIT 1303', 'prerequisite_code' => 'BICS 1301'], //System Analysis and Design
            ['course_code' => 'BICS 1303', 'prerequisite_code' => 'BICS 1302'], //Computer Networking
            ['course_code' => 'BICS 2305', 'prerequisite_code' => 'BICS 1302'], //Operating System
            //DCC
            ['course_code' => 'BIIT 2301', 'prerequisite_code' => 'BIIT 1301'], //User Experience Design
            ['course_code' => 'BIIT 2302', 'prerequisite_code' => 'BIIT 1302'], //Management of Information Security
            ['course_code' => 'BIIT 2303', 'prerequisite_code' => 'BICS 1301'], //Network Infrastructure Management
            ['course_code' => 'BIIT 2305', 'prerequisite_code' => 'BICS 1304'], //Web Application Development
            ['course_code' => 'BIIT 2305', 'prerequisite_code' => 'BIIT 2301'], //Web Application Development
            ['course_code' => 'BICS 1304', 'prerequisite_code' => 'BICS 1301'], //Object Oriented Programming
            //FYP
            ['course_code' => 'BIIT 4321', 'prerequisite_code' => 'BIIT 1301'], //Final Year Project 1
            ['course_code' => 'BIIT 4321', 'prerequisite_code' => 'BIIT 2303'], //Final Year Project 1
            ['course_code' => 'BIIT 4321', 'prerequisite_code' => 'BIIT 2305'], //Final Year Project 1
            ['course_code' => 'BIIT 4421', 'prerequisite_code' => 'BIIT 4321'], //Final Year Project 2
        ]);
    }
}
