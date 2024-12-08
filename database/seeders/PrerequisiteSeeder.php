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
            ['course_code' => 'BIIT 1303', 'prerequisite_code' => 'BICS 1301'],
            ['course_code' => 'BICS 1304', 'prerequisite_code' => 'BICS 1301'],
            ['course_code' => 'BICS 1303', 'prerequisite_code' => 'BICS 1302'],
            ['course_code' => 'BICS 2305', 'prerequisite_code' => 'BICS 1302'],
        ]);
    }
}
