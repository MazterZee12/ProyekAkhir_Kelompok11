<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facility;

class FacilitySeeder extends Seeder
{
    use ImageSeederHelper;

    private array $facilities = [
        [
            'name'        => 'Kamar Mandi & Toilet Umum',
            'description' => 'Fasilitas kamar mandi dan toilet umum yang bersih dan terawat tersedia di beberapa titik di kawasan wisata.',
            'url'         => 'https://images.unsplash.com/photo-1552321554-5fefe8c9ef14?w=600&q=80',
        ],
        [
            'name'        => 'Kamar Bilas',
            'description' => 'Kamar bilas tersedia untuk pengunjung yang selesai berenang atau bermain air agar dapat membersihkan diri dengan nyaman.',
            'url'         => 'https://images.unsplash.com/photo-1507652313519-d4e9174996dd?w=600&q=80',
        ],
        [
            'name'        => 'Area Parkir',
            'description' => 'Area parkir luas yang dapat menampung kendaraan roda dua maupun roda empat dengan aman dan teratur.',
            'url'         => 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?w=600&q=80',
        ],
        [
            'name'        => 'Warung & Rumah Makan',
            'description' => 'Tersedia warung makan dan rumah makan yang menyajikan berbagai kuliner khas Batak dan makanan umum dengan harga terjangkau.',
            'url'         => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=600&q=80',
        ],
        [
            'name'        => 'Gazebo & Area Bersantai',
            'description' => 'Gazebo dan area bersantai yang strategis dengan pemandangan langsung ke Danau Toba untuk menikmati suasana alam.',
            'url'         => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=600&q=80',
        ],
        [
            'name'        => 'Persewaan Perahu',
            'description' => 'Layanan persewaan perahu untuk wisatawan yang ingin mengelilingi kawasan danau dan menikmati pemandangan dari atas air.',
            'url'         => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&q=80',
        ],
        [
            'name'        => 'Area Berkemah',
            'description' => 'Area khusus berkemah dengan fasilitas pendukung untuk pengunjung yang ingin merasakan pengalaman menginap di tepi danau.',
            'url'         => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=600&q=80',
        ],
        [
            'name'        => 'Mushola',
            'description' => 'Fasilitas mushola yang bersih dan nyaman tersedia untuk pengunjung yang membutuhkan tempat beribadah.',
            'url'         => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?w=600&q=80',
        ],
    ];

    public function run(): void
    {
        foreach ($this->facilities as $i => $facility) {
            $this->command->info("Downloading facility image " . ($i + 1) . " of " . count($this->facilities) . "...");
            $path = $this->downloadImage($facility['url'], 'facilities');

            Facility::create([
                'name'        => $facility['name'],
                'description' => $facility['description'],
                'photo_path'  => $path,
            ]);
        }
    }
}
