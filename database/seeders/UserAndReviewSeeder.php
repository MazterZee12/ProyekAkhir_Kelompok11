<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Hash;

class UserAndReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Buat beberapa user biasa
        $users = [
            ['name' => 'Mark Zuckerberg',    'email' => 'Mark@gmail.com'],
            ['name' => 'Elon Musk',    'email' => 'Elon@gmail.com'],
            ['name' => 'Roni Simanullang','email' => 'roni@gmail.com'],
            ['name' => 'Dewi Situmorang', 'email' => 'dewi@gmail.com'],
            ['name' => 'Hendra Lumban',   'email' => 'hendra@gmail.com'],
            ['name' => 'Mega Pangaribuan','email' => 'mega@gmail.com'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                'password' => Hash::make('password123'),
                'role'     => 'user',
            ]);
        }

        // Buat ulasan dari masing-masing user
        $reviews = [
            [
                'user_email' => 'Mark@gmail.com',
                'rating'     => 5.0,
                'comment'    => 'Tempat yang luar biasa! Pasir putihnya bersih, airnya jernih, dan pemandangannya sangat memukau. Sangat recommended untuk liburan keluarga. Fasilitas juga lengkap dan terawat dengan baik.',
            ],
            [
                'user_email' => 'Elon@gmail.com',
                'rating'     => 4.5,
                'comment'    => 'Wisata yang sangat menyenangkan di tepi Danau Toba. Suasananya tenang dan nyaman. Kuliner khas Batak di sini enak-enak. Hanya saja antrian perahu agak panjang saat akhir pekan.',
            ],
            [
                'user_email' => 'roni@gmail.com',
                'rating'     => 5.0,
                'comment'    => 'Sudah beberapa kali ke sini dan selalu puas! Pemandangan sunsetnya juara banget. Area berkemahnya juga seru, sangat cocok untuk yang suka alam terbuka.',
            ],
            [
                'user_email' => 'dewi@gmail.com',
                'rating'     => 4.0,
                'comment'    => 'Tempatnya indah dan asri. Anak-anak sangat senang bermain di tepi danau. Fasilitas toilet sudah cukup baik. Semoga bisa terus dijaga kebersihannya.',
            ],
            [
                'user_email' => 'hendra@gmail.com',
                'rating'     => 4.5,
                'comment'    => 'Pengalaman berkemah di sini benar-benar tak terlupakan. Bisa melihat bintang dengan jelas di malam hari sambil mendengar suara alam. Harga sewa tenda sangat terjangkau.',
            ],
            [
                'user_email' => 'mega@gmail.com',
                'rating'     => 5.0,
                'comment'    => 'Destinasi wisata terbaik di kawasan Danau Toba! Pasir putihnya cantik, airnya bersih, dan petugas wisatanya ramah. Wajib dikunjungi kalau ke Sumatera Utara!',
            ],
        ];

        foreach ($reviews as $review) {
            $user = User::where('email', $review['user_email'])->first();
            if ($user) {
                Review::create([
                    'user_id' => $user->id,
                    'rating'  => $review['rating'],
                    'comment' => $review['comment'],
                ]);
            }
        }
    }
}
