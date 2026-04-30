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

        // Test user for resident
        User::updateOrCreate(
            ['email' => 'resident@example.com'],
            [
                'name' => 'Resident',
                'password' => bcrypt('password'),
                'role' => 'resident',
            ]
        );
    }
}
