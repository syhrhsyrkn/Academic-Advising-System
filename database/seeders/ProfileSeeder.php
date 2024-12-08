<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        $adminUser = User::where('email', 'admin@gmail.com')->first();
        if ($adminUser && !$adminUser->profile) {
            Profile::create([
                'user_id' => $adminUser->id,
                'email' => $adminUser->email,
                'full_name' => 'Admin Full Name',
                'contact_number' => '0123456789',
                'kulliyyah' => 'Kulliyyah of ICT',
                'department' => 'Administration',
                'staff_id' => 'A123456',
            ]);
        }

        $studentUser = User::where('email', 'student@gmail.com')->first();
        if ($studentUser && !$studentUser->profile) {
            Profile::create([
                'user_id' => $studentUser->id,
                'email'=> $studentUser->email,
                'full_name' => 'Student Full Name',
                'contact_number' => '0123456789',
                'kulliyyah' => 'Kulliyyah of ICT',
                'department' => 'Computer Science',
                'matric_no' => '2117277',
                'specialisation' => null,
                'year' => 1,
                'semester' => 1,
            ]);
        }

        // Attach profile to advisor user
        $advisorUser = User::where('email', 'advisor@gmail.com')->first();
        if ($advisorUser && !$advisorUser->profile) {
            Profile::create([
                'user_id' => $advisorUser->id,
                'email'=> $advisorUser->email,
                'full_name' => 'Advisor Full Name',
                'contact_number' => '0198765432',
                'kulliyyah' => 'Kulliyyah of ICT',
                'department' => 'Academic Advising',
                'staff_id' => 'S789101',
            ]);
        }

    }
}
