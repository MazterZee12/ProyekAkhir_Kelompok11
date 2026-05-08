<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'order'     => 1,
                'question'  => 'Berapa harga tiket masuk ke Pantai Pasir Putih Toba?',
                'answer'    => 'Harga tiket masuk untuk pengunjung dewasa adalah Rp10.000 per orang, sedangkan untuk anak-anak usia 5-12 tahun sebesar Rp5.000 per orang. Anak di bawah 5 tahun gratis. Biaya parkir motor Rp10.000 dan mobil Rp20.000.',
                'is_active' => true,
            ],
            [
                'order'     => 2,
                'question'  => 'Jam berapa Pantai Pasir Putih Toba buka?',
                'answer'    => 'Pada hari Senin sampai Jumat, kawasan wisata buka pukul 07.00 hingga 17.00 WIB. Pada hari Sabtu, Minggu, dan hari libur nasional, buka lebih awal mulai pukul 06.00 hingga 18.00 WIB.',
                'is_active' => true,
            ],
            [
                'order'     => 3,
                'question'  => 'Fasilitas apa saja yang tersedia di kawasan wisata?',
                'answer'    => 'Tersedia berbagai fasilitas lengkap meliputi kamar mandi dan toilet umum, kamar bilas, area parkir luas, warung makan dan rumah makan, gazebo dan area bersantai, persewaan perahu, area berkemah, dan mushola.',
                'is_active' => true,
            ],
            [
                'order'     => 4,
                'question'  => 'Bagaimana cara menuju Pantai Pasir Putih Toba dari Medan?',
                'answer'    => 'Dari Medan, ikuti Jalan Lintas Sumatera menuju arah Parapat dengan waktu tempuh sekitar 4 jam. Dari Parapat, lanjutkan perjalanan menuju Ajibata sekitar 15 menit. Tersedia juga angkutan umum dari Terminal Parapat menuju kawasan wisata.',
                'is_active' => true,
            ],
            [
                'order'     => 5,
                'question'  => 'Apakah tersedia fasilitas berkemah di sini?',
                'answer'    => 'Ya, tersedia area berkemah khusus dengan fasilitas pendukung. Pengunjung dapat menyewa tenda dengan kapasitas 2-3 orang seharga Rp100.000 per malam, sudah termasuk matras. Pemandangan langsung ke Danau Toba menjadikan pengalaman berkemah semakin berkesan.',
                'is_active' => true,
            ],
            [
                'order'     => 6,
                'question'  => 'Apakah aman untuk berenang di Danau Toba?',
                'answer'    => 'Kawasan danau di area wisata relatif aman untuk berenang dan bermain air. Namun pengunjung tetap wajib memperhatikan tanda-tanda keselamatan yang dipasang di sekitar area air. Anak-anak wajib dalam pengawasan orang tua. Tersedia juga layanan sewa pelampung untuk keamanan tambahan.',
                'is_active' => true,
            ],
            [
                'order'     => 7,
                'question'  => 'Apakah ada wahana atau aktivitas yang tersedia selain berenang?',
                'answer'    => 'Tersedia berbagai aktivitas seru seperti naik perahu wisata, banana boat, berkemah, dan menikmati kuliner khas Batak. Pada akhir pekan dan hari libur tertentu juga sering diadakan pertunjukan seni budaya lokal.',
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
