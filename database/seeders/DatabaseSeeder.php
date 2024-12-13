<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            StudentSeeder::class,
            StaffSeeder::class,
            // CourseSeeder::class,
            // PrerequisiteSeeder::class,
        ]);
    }
}
