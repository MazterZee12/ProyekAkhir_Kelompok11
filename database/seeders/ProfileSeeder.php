<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::create([
            'name'             => 'Pantai Pasir Putih Toba',
            'description'      => 'Pantai Pasir Putih Toba adalah destinasi wisata alam yang menawarkan keindahan tepi Danau Toba dengan hamparan pasir putih yang bersih, air yang jernih, dan pemandangan alam yang menakjubkan.',
            'history'          => 'Kawasan wisata Pantai Pasir Putih Toba telah dikenal sejak lama oleh masyarakat sekitar Kabupaten Toba sebagai tempat rekreasi keluarga. Sejak resmi dikelola secara profesional, lokasi ini terus berkembang dengan penambahan fasilitas dan infrastruktur pendukung untuk memberikan kenyamanan maksimal bagi setiap pengunjung.',
            'vision'           => 'Menjadi destinasi wisata alam unggulan di kawasan Danau Toba yang berkelanjutan, berdaya saing, dan memberikan manfaat nyata bagi masyarakat lokal.',
            'mission'          => 'Menyediakan fasilitas wisata yang lengkap dan nyaman, menjaga kelestarian lingkungan alam sekitar, memberdayakan masyarakat lokal melalui sektor pariwisata, dan memberikan pengalaman wisata yang tak terlupakan bagi setiap pengunjung.',
            'established_year' => 2015,
            'regulations'      => "1. Pengunjung wajib menjaga kebersihan area wisata.\n2. Dilarang membuang sampah sembarangan.\n3. Dilarang merusak fasilitas dan lingkungan sekitar.\n4. Pengunjung bertanggung jawab atas keselamatan diri sendiri.\n5. Anak-anak wajib dalam pengawasan orang tua atau pendamping.\n6. Dilarang membawa minuman keras ke dalam area wisata.",
            'logo_path'        => null,
            'is_active'        => true,
        ]);
    }
}
