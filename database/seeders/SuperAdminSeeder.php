<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if a super-admin already exists
        $superAdminEmail = 'superadmin@example.com';

        $superAdmin = User::where('email', $superAdminEmail)->first();

        if (!$superAdmin) {
            User::create([
                'name' => 'Super Admin',
                'email' => $superAdminEmail,
                'password' => Hash::make('SuperSecret123!'), // change to a secure password
                'role' => 'super-admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);

            $this->command->info('Super Admin user created successfully.');
        } else {
            $this->command->info('Super Admin already exists.');
        }
    }
}
