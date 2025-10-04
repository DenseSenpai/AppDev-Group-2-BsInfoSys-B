<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ✅ Create default admin account if it doesn’t exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // Lookup by email
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'), // Change to your desired password
                'role' => 'admin', // Make sure your User model has this column
            ]
        );
    }
}
