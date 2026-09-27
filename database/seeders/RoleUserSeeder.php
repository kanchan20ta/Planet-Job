<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        // Fixed, predictable login accounts for demo/testing
        User::updateOrCreate(
            ['email' => 'admin@planetjob.com'],
            [
                'name' => 'Planet Job Admin',
                'phone' => '9800000001',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'employer@planetjob.com'],
            [
                'name' => 'Demo Employer',
                'phone' => '9800000002',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'jobseeker@planetjob.com'],
            [
                'name' => 'Demo Jobseeker',
                'phone' => '9800000003',
                'password' => Hash::make('password'),
                'role' => 'jobseeker',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
