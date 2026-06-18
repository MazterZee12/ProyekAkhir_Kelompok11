<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('email', [
            'andi.siaputra@example.com',
            'rina.sihotang@example.com',
            'budi.simanjuntak@example.com',
            'maya.siregar@example.com',
            'doni.hutapea@example.com',
            'sinta.harahap@example.com',
            'rio.pasaribu@example.com',
            'nia.nainggolan@example.com',
            'toni.marbun@example.com',
            'lina.manurung@example.com',
        ])->get()->keyBy('email');

        $reviews = [
            [
                'email' => 'andi.siaputra@example.com',
                'visit_date' => '2026-01-05',
                'rating' => 5,
                'comment' => 'Tempatnya bagus sekali, pasir putihnya bersih dan enak buat duduk santai. Saya datang sama keluarga dan anak-anak paling senang main pasir di pinggir danau. Suasananya tenang, cocok banget buat liburan singkat.',
            ],
            [
                'email' => 'rina.sihotang@example.com',
                'visit_date' => '2026-01-12',
                'rating' => 4.5,
                'comment' => 'Pemandangannya keren banget, apalagi waktu pagi masih sepi. Anginnya sejuk dan tempatnya lumayan rapi. Kalau datang sore pasti lebih enak lagi buat lihat sunset.',
            ],
            [
                'email' => 'budi.simanjuntak@example.com',
                'visit_date' => '2026-01-20',
                'rating' => 4,
                'comment' => 'Secara keseluruhan bagus, terutama view Danau Tobanya. Area duduk dan gazebo juga membantu kalau mau santai lama. Cuma pas saya datang agak ramai, jadi agak susah cari tempat teduh.',
            ],
            [
                'email' => 'maya.siregar@example.com',
                'visit_date' => '2026-02-02',
                'rating' => 5,
                'comment' => 'Menurut saya ini salah satu tempat wisata yang wajib dikunjungi kalau ke Toba. Pasirnya putih, air danaunya tenang, dan banyak spot foto yang cantik. Sangat puas datang ke sini.',
            ],
            [
                'email' => 'doni.hutapea@example.com',
                'visit_date' => '2026-02-10',
                'rating' => 4.5,
                'comment' => 'Tempatnya nyaman buat jalan-jalan sore. Anak-anak bisa bermain, orang tua juga bisa duduk santai. Parkirnya cukup membantu dan akses ke lokasi juga tidak terlalu susah.',
            ],
            [
                'email' => 'sinta.harahap@example.com',
                'visit_date' => '2026-02-18',
                'rating' => 5,
                'comment' => 'Saya suka suasana pantainya, bersih dan terlihat terawat. Cocok untuk piknik kecil bersama keluarga. Kalau ditambah beberapa fasilitas lagi pasti makin bagus.',
            ],
            [
                'email' => 'rio.pasaribu@example.com',
                'visit_date' => '2026-03-01',
                'rating' => 4,
                'comment' => 'View-nya luar biasa, apalagi latar bukit dan danaunya. Datang siang agak panas, jadi lebih enak kalau pagi atau sore. Tapi untuk tempat santai, ini sudah sangat oke.',
            ],
            [
                'email' => 'nia.nainggolan@example.com',
                'visit_date' => '2026-03-09',
                'rating' => 5,
                'comment' => 'Liburan keluarga jadi menyenangkan di sini. Anak saya betah banget main pasir, sedangkan kami bisa menikmati pemandangan Danau Toba. Tempatnya cocok untuk semua umur.',
            ],
            [
                'email' => 'toni.marbun@example.com',
                'visit_date' => '2026-03-20',
                'rating' => 4.5,
                'comment' => 'Tempat ini punya daya tarik yang kuat karena pemandangannya unik. Rasanya seperti pantai di tepi danau yang tenang. Saya rasa kalau kebersihan dijaga terus, tempat ini bisa semakin ramai dikunjungi.',
            ],
            [
                'email' => 'lina.manurung@example.com',
                'visit_date' => '2026-04-04',
                'rating' => 5,
                'comment' => 'Pertama kali ke sini dan langsung suka. Suasananya adem, pemandangannya cantik, dan tempatnya enak untuk foto-foto. Saya pasti balik lagi kalau ada kesempatan ke Toba.',
            ],
        ];

        foreach ($reviews as $review) {
            $user = $users->get($review['email']);

            if (!$user) {
                continue;
            }

            Review::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'visit_date' => $review['visit_date'],
                    'comment' => $review['comment'],
                ],
                [
                    'user_id' => $user->id,
                    'visit_date' => $review['visit_date'],
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'is_hidden' => false,
                ]
            );
        }
    }
}
