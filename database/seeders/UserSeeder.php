<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin A',
                'password' => Hash::make('admin123'),
            ]
        );
        $admin->assignRole('admin');

        // Create student user
        $student = User::firstOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'Student A',
                'password' => Hash::make('student123'),
            ]
        );
        $student->assignRole('student');

        $student = User::firstOrCreate(
            ['email' => 'student2@gmail.com'],
            [
                'name' => 'Student B',
                'password' => Hash::make('student123'),
            ]
        );
        $student->assignRole('student');

        // Create advisor user
        $advisor = User::firstOrCreate(
            ['email' => 'advisor@gmail.com'],
            [
                'name' => 'Advisor A',
                'password' => Hash::make('advisor123'),
            ]
        );
        $advisor->assignRole('advisor');
    }
}