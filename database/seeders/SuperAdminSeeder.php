<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Check if a super-admin already exists
        $superAdmin = User::where('email', 'superadmin@example.com')->first();
        if (!$superAdmin) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('Password123!'), // Set a secure password
                'role' => 'super-admin', // This is critical
            ]);

            $this->command->info('Super Admin created: superadmin@example.com / Password123!');
        } else {
            $this->command->info('Super Admin already exists.');
        }
    }
}
