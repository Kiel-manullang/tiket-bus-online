<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Tiket Bus',
            'email' => 'admin@tiketbus.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // User 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567891',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // User 2
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'phone' => '081234567892',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // User 3
        User::create([
            'name' => 'Ahmad Fadli',
            'email' => 'ahmad@example.com',
            'phone' => '081234567893',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // User 4
        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@example.com',
            'phone' => '081234567894',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        // User 5
        User::create([
            'name' => 'Rizki Pratama',
            'email' => 'rizki@example.com',
            'phone' => '081234567895',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $this->command->info('✓ Users created successfully!');
        $this->command->info('Admin: admin@tiketbus.com / password123');
        $this->command->info('Users: budi@example.com, siti@example.com, etc / password123');
    }
}