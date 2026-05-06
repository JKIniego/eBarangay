<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Test user for admin
        // Admin 1
        User::updateOrCreate(
            ['email' => 'admin1@example.com'],
            [
                'name' => 'Admin One',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Admin 2
        User::updateOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin Two',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        // Test users for resident
        // Resident 1
        User::updateOrCreate(
            ['email' => 'resident1@example.com'],
            [
                'name' => 'Resident One',
                'password' => bcrypt('password'),
                'role' => 'resident'
            ]
        );

        // Resident 2
        User::updateOrCreate(
            ['email' => 'resident2@example.com'],
            [
                'name' => 'Resident Two',
                'password' => bcrypt('password'),
                'role' => 'resident'
            ]
        );
    }
}
