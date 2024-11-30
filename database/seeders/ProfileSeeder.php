<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        // Attach profile to admin user
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser && !$adminUser->profile) {
            Profile::create([
                'user_id' => $adminUser->id,
                'full_name' => 'Admin Full Name',
                'contact_number' => '0123456789',
                'kulliyyah' => 'Kulliyyah of ICT',
                'department' => 'Administration',
                'staff_id' => 'A123456',
            ]);
        }

        // Attach profile to student user
        $studentUser = User::where('email', 'student@gmail.com')->first();
        if ($studentUser && !$studentUser->profile) {
            Profile::create([
                'user_id' => $studentUser->id,
                'full_name' => 'Student Full Name',
                'contact_number' => '0987654321',
                'kulliyyah' => 'Kulliyyah of ICT',
                'department' => 'Computer Science',
                'matric_no' => 'G1234567',
                'specialisation' => 'Software Engineering',
                'year' => 2,
                'semester' => 1,
            ]);
        }

        // Attach profile to advisor user
        $advisorUser = User::where('email', 'advisor@gmail.com')->first();
        if ($advisorUser && !$advisorUser->profile) {
            Profile::create([
                'user_id' => $advisorUser->id,
                'full_name' => 'Advisor Full Name',
                'contact_number' => '0198765432',
                'kulliyyah' => 'Kulliyyah of ICT',
                'department' => 'Academic Advising',
                'staff_id' => 'S789101',
            ]);
        }

        $this->command->info('Profiles for admin, student, and advisor seeded successfully!');
    }
}
