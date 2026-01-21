<?php

namespace Database\Seeders;

use App\Models\Bus;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        // Data Armada Sampri (Minibus L300/HiAce)
        $buses = [
            [
                'name' => 'Sampri 01',
                'plate_number' => 'BB 1001 AA',
                'capacity' => 12,
                'facilities' => 'AC, Musik, Reclining Seat',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 02',
                'plate_number' => 'BB 1002 AA',
                'capacity' => 12,
                'facilities' => 'AC, Musik, Reclining Seat',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 03',
                'plate_number' => 'BB 1003 AA',
                'capacity' => 12,
                'facilities' => 'AC, Musik',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 04',
                'plate_number' => 'BB 1004 AA',
                'capacity' => 12,
                'facilities' => 'AC, Musik',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 05',
                'plate_number' => 'BB 1005 AB',
                'capacity' => 12,
                'facilities' => 'AC, Musik, Bagasi Luas',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 06',
                'plate_number' => 'BB 1006 AB',
                'capacity' => 12,
                'facilities' => 'AC, Musik',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 07 (Cadangan)',
                'plate_number' => 'BB 1007 XX',
                'capacity' => 12,
                'facilities' => 'Non-AC, Musik', // Kadang ada armada non-AC/Ekonomi
                'status' => 'inactive', // Sedang tidak jalan
            ],
            [
                'name' => 'Sampri 08',
                'plate_number' => 'BB 1008 AC',
                'capacity' => 12,
                'facilities' => 'AC, Musik, Charger HP',
                'status' => 'active',
            ],
            [
                'name' => 'Sampri 09 (Maintenance)',
                'plate_number' => 'BB 1009 AC',
                'capacity' => 12,
                'facilities' => 'AC, Musik',
                'status' => 'maintenance', // Sedang di bengkel
            ],
            [
                'name' => 'Sampri 10',
                'plate_number' => 'BB 1010 AD',
                'capacity' => 14, // HiAce biasanya lebih besar dikit
                'facilities' => 'AC, Musik, Reclining Seat, USB Charger',
                'status' => 'active',
            ],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }

        $this->command->info('✓ Armada Sampri berhasil dibuat!');
    }
}