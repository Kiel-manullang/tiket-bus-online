<?php

namespace Database\Seeders;

use App\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // Medan - Doloksanggul (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Doloksanggul',
                'distance' => 280,
                'duration' => '7-8 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Doloksanggul',
                'destination' => 'Medan',
                'distance' => 280,
                'duration' => '7-8 jam',
                'status' => 'active',
            ],

            // Medan - Pangururan (Samosir) (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Pangururan (Samosir)',
                'distance' => 200,
                'duration' => '5-6 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Pangururan (Samosir)',
                'destination' => 'Medan',
                'distance' => 200,
                'duration' => '5-6 jam',
                'status' => 'active',
            ],

            // Medan - Balige (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Balige',
                'distance' => 230,
                'duration' => '6 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Balige',
                'destination' => 'Medan',
                'distance' => 230,
                'duration' => '6 jam',
                'status' => 'active',
            ],

            // Medan - Tarutung (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Tarutung',
                'distance' => 285,
                'duration' => '7 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Tarutung',
                'destination' => 'Medan',
                'distance' => 285,
                'duration' => '7 jam',
                'status' => 'active',
            ],

            // Medan - Sibolga (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Sibolga',
                'distance' => 350,
                'duration' => '9-10 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Sibolga',
                'destination' => 'Medan',
                'distance' => 350,
                'duration' => '9-10 jam',
                'status' => 'active',
            ],

            // Medan - Parapat (Danau Toba) (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Parapat',
                'distance' => 170,
                'duration' => '4-5 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Parapat',
                'destination' => 'Medan',
                'distance' => 170,
                'duration' => '4-5 jam',
                'status' => 'active',
            ],

            // Medan - Sidikalang (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Sidikalang',
                'distance' => 160,
                'duration' => '5 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Sidikalang',
                'destination' => 'Medan',
                'distance' => 160,
                'duration' => '5 jam',
                'status' => 'active',
            ],

            // Medan - Pematang Siantar (PP)
            [
                'origin' => 'Medan',
                'destination' => 'Pematang Siantar',
                'distance' => 130,
                'duration' => '3 jam',
                'status' => 'active',
            ],
            [
                'origin' => 'Pematang Siantar',
                'destination' => 'Medan',
                'distance' => 130,
                'duration' => '3 jam',
                'status' => 'active',
            ],
        ];

        foreach ($routes as $route) {
            Route::create($route);
        }

        $this->command->info('✓ Rute Sumatera Utara berhasil dibuat!');
    }
}