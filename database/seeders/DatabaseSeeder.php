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
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
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
