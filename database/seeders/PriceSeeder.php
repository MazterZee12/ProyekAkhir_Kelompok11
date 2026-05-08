<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Price;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        $prices = [
            // Tiket masuk
            [
                'type'      => 'ticket',
                'amount'    => 10000,
                'unit'      => 'per orang',
                'notes'     => 'Berlaku untuk pengunjung dewasa. Anak di bawah 5 tahun gratis.',
                'is_active' => true,
            ],
            [
                'type'      => 'ticket',
                'amount'    => 5000,
                'unit'      => 'per orang (anak-anak)',
                'notes'     => 'Berlaku untuk anak usia 5-12 tahun.',
                'is_active' => true,
            ],
            [
                'type'      => 'ticket',
                'amount'    => 10000,
                'unit'      => 'per motor',
                'notes'     => 'Biaya parkir kendaraan roda dua.',
                'is_active' => true,
            ],
            [
                'type'      => 'ticket',
                'amount'    => 20000,
                'unit'      => 'per mobil',
                'notes'     => 'Biaya parkir kendaraan roda empat.',
                'is_active' => true,
            ],
            // Sewa fasilitas
            [
                'type'      => 'rental',
                'amount'    => 50000,
                'unit'      => 'per jam',
                'notes'     => 'Sewa perahu wisata kapasitas 4-6 orang. Termasuk pemandu.',
                'is_active' => true,
            ],
            [
                'type'      => 'rental',
                'amount'    => 25000,
                'unit'      => 'per jam',
                'notes'     => 'Sewa pelampung untuk aktivitas air.',
                'is_active' => true,
            ],
            [
                'type'      => 'rental',
                'amount'    => 100000,
                'unit'      => 'per malam',
                'notes'     => 'Sewa tenda kemping kapasitas 2-3 orang. Sudah termasuk matras.',
                'is_active' => true,
            ],
            [
                'type'      => 'rental',
                'amount'    => 30000,
                'unit'      => 'per sesi',
                'notes'     => 'Sewa gazebo untuk 1 sesi (3 jam). Maksimal 6 orang.',
                'is_active' => true,
            ],
        ];

        foreach ($prices as $price) {
            Price::create($price);
        }
    }
}
