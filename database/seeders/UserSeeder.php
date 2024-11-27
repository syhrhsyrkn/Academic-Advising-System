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
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
            ]
        );
        $admin->assignRole('admin');

        // Create student user
        $student = User::firstOrCreate(
            ['email' => 'student@gmail.com'],
            [
                'name' => 'Student',
                'password' => Hash::make('12345678'),
            ]
        );
        $student->assignRole('student');

        // Create advisor user
        $advisor = User::firstOrCreate(
            ['email' => 'advisor@gmail.com'],
            [
                'name' => 'Advisor',
                'password' => Hash::make('12345678'),
            ]
        );
        $advisor->assignRole('advisor');
    }
}