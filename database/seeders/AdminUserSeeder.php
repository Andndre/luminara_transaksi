<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user exists to prevent duplicate error
        if (!User::where('email', 'admin@luminara.com')->exists()) {
            User::create([
                'name' => 'Admin Luminara',
                'email' => 'admin@luminara.com',
                'password' => Hash::make('password'), // Default password
            ]);
        }
    }
}
