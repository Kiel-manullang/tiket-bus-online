<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua bus aktif
        $buses = Bus::where('status', 'active')->get();
        // Ambil semua rute aktif
        $routes = Route::active()->get();

        // Cek jika data kosong, jangan lanjut biar gak error
        if ($buses->isEmpty() || $routes->isEmpty()) {
            $this->command->error('Data Bus atau Rute kosong! Jalankan BusSeeder & RouteSeeder dulu.');
            return;
        }

        // Tanggal mulai (Hari ini)
        $startDate = now();
        
        // Buat jadwal untuk 7 hari ke depan
        foreach (range(0, 6) as $dayOffset) {
            $date = $startDate->copy()->addDays($dayOffset);

            // 1. Medan - Doloksanggul (Pagi & Malam)
            $medanDolok = $routes->where('origin', 'Medan')->where('destination', 'Doloksanggul')->first();
            if ($medanDolok) {
                // Pagi
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $medanDolok->id,
                    'departure_date' => $date,
                    'departure_time' => '08:00',
                    'arrival_time' => '16:00',
                    'price' => 120000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
                // Malam
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $medanDolok->id,
                    'departure_date' => $date,
                    'departure_time' => '20:00',
                    'arrival_time' => '04:00',
                    'price' => 130000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
            }

            // 2. Doloksanggul - Medan (Pagi & Malam)
            $dolokMedan = $routes->where('origin', 'Doloksanggul')->where('destination', 'Medan')->first();
            if ($dolokMedan) {
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $dolokMedan->id,
                    'departure_date' => $date,
                    'departure_time' => '08:00',
                    'arrival_time' => '16:00',
                    'price' => 120000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $dolokMedan->id,
                    'departure_date' => $date,
                    'departure_time' => '20:00',
                    'arrival_time' => '04:00',
                    'price' => 130000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
            }

            // 3. Medan - Balige
            $medanBalige = $routes->where('origin', 'Medan')->where('destination', 'Balige')->first();
            if ($medanBalige) {
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $medanBalige->id,
                    'departure_date' => $date,
                    'departure_time' => '09:00',
                    'arrival_time' => '15:00',
                    'price' => 100000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
            }

            // 4. Medan - Samosir
            $medanSamosir = $routes->where('origin', 'Medan')->where('destination', 'Pangururan (Samosir)')->first();
            if ($medanSamosir) {
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $medanSamosir->id,
                    'departure_date' => $date,
                    'departure_time' => '07:30',
                    'arrival_time' => '13:30',
                    'price' => 110000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
            }
            
            // 5. Medan - Tarutung
            $medanTarutung = $routes->where('origin', 'Medan')->where('destination', 'Tarutung')->first();
            if ($medanTarutung) {
                Schedule::create([
                    'bus_id' => $buses->random()->id,
                    'route_id' => $medanTarutung->id,
                    'departure_date' => $date,
                    'departure_time' => '21:00',
                    'arrival_time' => '04:00',
                    'price' => 140000,
                    'available_seats' => 12,
                    'status' => 'active',
                ]);
            }
        }

        $this->command->info('✓ Jadwal Sumut berhasil dibuat!');
    }
}