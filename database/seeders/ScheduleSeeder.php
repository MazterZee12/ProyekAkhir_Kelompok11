<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            [
                'day'            => 'Senin - Jumat',
                'open_time'      => '07:00',
                'close_time'     => '17:00',
                'capacity'       => 300,
                'best_time'      => 'Pagi hari (07.00 - 10.00) untuk menghindari terik matahari',
                'parking_info'   => 'Area parkir tersedia untuk motor dan mobil. Kapasitas ±100 kendaraan. Biaya parkir terpisah dari tiket masuk.',
                'transport_info' => 'Dapat dijangkau dengan angkutan umum dari Terminal Parapat. Tersedia ojek online di sekitar kawasan wisata.',
                'route_info'     => 'Dari Medan: Jalan Lintas Sumatera arah Parapat ± 4 jam. Dari Parapat: ikuti jalan menuju Ajibata ± 15 menit.',
                'weather_embed'  => null,
                'is_active'      => true,
            ],
            [
                'day'            => 'Sabtu - Minggu & Hari Libur',
                'open_time'      => '06:00',
                'close_time'     => '18:00',
                'capacity'       => 500,
                'best_time'      => 'Pagi hari (06.00 - 09.00) sebelum pengunjung ramai berdatangan',
                'parking_info'   => 'Pada akhir pekan, area parkir tambahan dibuka di lapangan sebelah. Disarankan datang lebih awal untuk mendapat tempat parkir.',
                'transport_info' => 'Pada akhir pekan tersedia shuttle khusus dari Parapat setiap 30 menit sekali mulai pukul 07.00.',
                'route_info'     => 'Dari Medan: Jalan Lintas Sumatera arah Parapat ± 4 jam. Dari Parapat: ikuti jalan menuju Ajibata ± 15 menit.',
                'weather_embed'  => null,
                'is_active'      => true,
            ],
        ];

        foreach ($schedules as $schedule) {
            Schedule::create($schedule);
        }
    }
}
