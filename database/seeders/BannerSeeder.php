<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    use ImageSeederHelper;

    // Foto pantai/danau Toba dari Unsplash (resolusi 1600px)
    private array $bannerImages = [
        'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80', // danau pegunungan
        'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1600&q=80', // pantai pasir putih
        'https://images.unsplash.com/photo-1471922694854-ff1b63b20054?w=1600&q=80', // tepi danau
    ];

    public function run(): void
    {
        $banners = [
            [
                'title'    => 'Surga Tersembunyi di Tepian Danau Toba',
                'subtitle' => 'Rasakan keindahan hamparan pasir putih dan air danau yang jernih',
                'url'      => null,
                'order'    => 1,
                'is_active'=> true,
            ],
            [
                'title'    => 'Festival Danau Toba 2026',
                'subtitle' => 'Saksikan pertunjukan seni budaya Batak yang memukau',
                'url'      => null,
                'order'    => 2,
                'is_active'=> true,
            ],
            [
                'title'    => 'Liburan Tak Terlupakan Bersama Keluarga',
                'subtitle' => 'Berbagai wahana dan fasilitas lengkap untuk semua usia',
                'url'      => null,
                'order'    => 3,
                'is_active'=> true,
            ],
        ];

        foreach ($banners as $i => $data) {
            $this->command->info("Downloading banner image " . ($i + 1) . "...");
            $imagePath = $this->downloadImage($this->bannerImages[$i], 'banners');
            $data['image_path'] = $imagePath ?? 'banners/placeholder.jpg';
            Banner::create($data);
        }
    }
}
