<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🚀 Starting database seeding...');
        $this->command->newLine();

        $this->call([
            UserSeeder::class,
            BusSeeder::class,
            RouteSeeder::class,
            ScheduleSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ All seeders completed successfully!');
        $this->command->newLine();

        // Summary
        $this->command->line('📊 Database Summary:');
        $this->command->line('- Users: ' . \App\Models\User::count());
        $this->command->line('- Buses: ' . \App\Models\Bus::count());
        $this->command->line('- Routes: ' . \App\Models\Route::count());
        $this->command->line('- Schedules: ' . \App\Models\Schedule::count());
        $this->command->newLine();

        $this->command->line('🔑 Login Credentials:');
        $this->command->line('Admin:');
        $this->command->line('  Email: admin@tiketbus.com');
        $this->command->line('  Password: password123');
        $this->command->newLine();
        $this->command->line('User:');
        $this->command->line('  Email: budi@example.com');
        $this->command->line('  Password: password123');
        $this->command->newLine();
    }
}