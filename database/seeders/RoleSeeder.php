<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $advisorRole = Role::firstOrCreate(['name' => 'advisor']);

        // Assign permissions to roles
        $adminRole->givePermissionTo('create courses');
        $studentRole->givePermissionTo('view courses');
        $advisorRole->givePermissionTo('view courses');
    }
}
