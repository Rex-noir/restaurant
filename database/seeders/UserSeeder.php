<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(UserProfile::factory(), 'profile')
            ->admin()->create([
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password')
                ]);

        User::factory()
            ->has(UserProfile::factory(), 'profile')
            ->create([
                'name' => 'Test Customer',
                'email' => 'test@example.com',
            ])->assignRole('customer');
    }
}
