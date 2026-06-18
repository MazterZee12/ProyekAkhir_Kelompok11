<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'name' => 'Pantai Pasir Putih Parparean',
            'description' => 'Pantai Pasir Putih Parparean merupakan salah satu destinasi wisata unggulan di Kabupaten Toba yang berada di kawasan Danau Toba. Keunikan pantai ini terletak pada hamparan pasir putih yang luas dan lembut, berpadu dengan panorama perbukitan hijau dan air Danau Toba yang tenang. Suasana yang nyaman menjadikan tempat ini cocok sebagai tujuan wisata keluarga, rekreasi, maupun kegiatan santai bersama teman dan kerabat.',
            'history' => 'Pantai Pasir Putih Parparean terletak di Desa Parparean II, Kecamatan Porsea, Kabupaten Toba. Kawasan ini berkembang menjadi destinasi wisata karena memiliki karakteristik yang berbeda dibandingkan sebagian besar tepian Danau Toba yang didominasi bebatuan. Hamparan pasir putih yang luas menjadi daya tarik utama bagi masyarakat lokal maupun wisatawan dari luar daerah. Seiring meningkatnya jumlah pengunjung, kawasan ini mulai dilengkapi dengan berbagai fasilitas seperti gazebo, area parkir, jalur pejalan kaki, area bermain, serta pusat kuliner untuk menunjang kenyamanan wisatawan.',
            'vision' => 'Menjadi destinasi wisata unggulan Danau Toba yang berkelanjutan, nyaman, aman, bersih, dan memberikan manfaat ekonomi bagi masyarakat sekitar.',
            'mission' => "Menjaga kebersihan dan kelestarian lingkungan kawasan wisata, meningkatkan kualitas pelayanan kepada wisatawan, menyediakan fasilitas wisata yang aman dan nyaman, mendukung pemberdayaan masyarakat lokal melalui kegiatan ekonomi kreatif dan pariwisata, serta mempromosikan potensi wisata Kabupaten Toba secara berkelanjutan.",
            'established_year' => 2018,
            'regulations' => "- Menjaga kebersihan area wisata dengan membuang sampah pada tempatnya.\n- Dilarang merusak fasilitas umum yang tersedia.\n- Dilarang membawa benda berbahaya yang dapat mengganggu kenyamanan pengunjung lain.\n- Anak-anak wajib berada dalam pengawasan orang tua saat bermain di area pantai.\n- Menjaga ketertiban dan menghormati sesama pengunjung.\n- Mengutamakan keselamatan saat melakukan aktivitas wisata di sekitar pantai.",
            'is_active' => true,
        ]);
    }
}
