<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Dimana lokasi Pantai Pasir Putih Parparean?',
                'answer' => 'Pantai Pasir Putih Parparean berada di Desa Parparean II, Kecamatan Porsea, Kabupaten Toba, Sumatera Utara.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'question' => 'Apa yang menjadi daya tarik utama Pantai Pasir Putih Parparean?',
                'answer' => 'Daya tarik utamanya adalah hamparan pasir putih yang luas, panorama Danau Toba, perbukitan hijau, serta suasana yang cocok untuk wisata keluarga.',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah tersedia area parkir?',
                'answer' => 'Ya, tersedia area parkir untuk kendaraan roda dua maupun roda empat.',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah tersedia tempat makan di sekitar lokasi?',
                'answer' => 'Tersedia berbagai warung yang menjual makanan ringan, minuman, dan beberapa kuliner lokal.',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah pantai ini cocok untuk keluarga?',
                'answer' => 'Ya. Pantai Pasir Putih Parparean merupakan salah satu destinasi wisata keluarga yang populer di Kabupaten Toba.',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'question' => 'Apakah tersedia gazebo untuk bersantai?',
                'answer' => 'Ya, tersedia gazebo yang dapat digunakan atau disewa pengunjung untuk beristirahat bersama keluarga.',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'question' => 'Kapan waktu terbaik berkunjung?',
                'answer' => 'Pagi dan sore hari merupakan waktu yang disukai wisatawan karena cuaca lebih sejuk dan pemandangan Danau Toba terlihat lebih indah.',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'question' => 'Aktivitas apa saja yang dapat dilakukan?',
                'answer' => 'Wisatawan dapat berjalan santai, jogging, berfoto, bermain pasir, bersantai di gazebo, menikmati kuliner, dan menikmati panorama Danau Toba.',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}
