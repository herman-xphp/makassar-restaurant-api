<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin Restaurant',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }
    }
}
