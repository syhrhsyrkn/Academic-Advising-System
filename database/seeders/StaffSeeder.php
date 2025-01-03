<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\User;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();

        if ($admin && !DB::table('staff')->where('user_id', $admin->id)->exists()) {
            DB::table('staff')->insert([
                'user_id' => $admin->id,
                'full_name' => 'Admin A',
                'contact_no' => '0112233445',
                'staff_id' => '5302853',
                'kulliyyah' => 'KICT',
                'department' => 'Department of Information Systems',
            ]);
        }

        $advisor = User::where('email', 'advisor@gmail.com')->first();

        if ($advisor && !DB::table('staff')->where('user_id', $advisor->id)->exists()) {
            DB::table('staff')->insert([
                'user_id' => $advisor->id,
                'full_name' => 'Advisor A',
                'contact_no' => '0155667788',
                'staff_id' => '5302854',
                'kulliyyah' => 'KICT',
                'department' => 'Department of Information Systems',
            ]);
        }
    }
}
