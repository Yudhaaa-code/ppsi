<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminDeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@sixmonkeys.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Create Developer User
        User::updateOrCreate(
            ['email' => 'developer@sixmonkeys.com'],
            [
                'name' => 'Developer',
                'password' => Hash::make('developer123'),
                'role' => 'developer',
            ]
        );

        $this->command->info('Admin dan Developer user berhasil dibuat!');
        $this->command->info('Admin: admin@sixmonkeys.com / admin123');
        $this->command->info('Developer: developer@sixmonkeys.com / developer123');
    }
}
