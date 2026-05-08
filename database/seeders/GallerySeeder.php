<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gallery;
use Illuminate\Support\Str;

class GallerySeeder extends Seeder
{
    use ImageSeederHelper;

    private array $items = [
        [
            'title'       => 'Pemandangan Pantai Pagi Hari',
            'description' => 'Suasana pantai di pagi hari dengan cahaya matahari yang hangat.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800&q=80',
        ],
        [
            'title'       => 'Hamparan Pasir Putih',
            'description' => 'Pasir putih bersih membentang di tepi Danau Toba.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80',
        ],
        [
            'title'       => 'Aktivitas Perahu Wisata',
            'description' => 'Pengunjung menikmati naik perahu mengelilingi kawasan wisata.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
        [
            'title'       => 'Sunset di Danau Toba',
            'description' => 'Pemandangan matahari terbenam yang memukau di tepi danau.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80',
        ],
        [
            'title'       => 'Area Berkemah',
            'description' => 'Fasilitas camping dengan pemandangan langsung ke Danau Toba.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?w=800&q=80',
        ],
        [
            'title'       => 'Kuliner Khas Batak',
            'description' => 'Berbagai pilihan kuliner khas Batak tersedia di kawasan wisata.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80',
        ],
        [
            'title'       => 'Wahana Air',
            'description' => 'Berbagai wahana air tersedia untuk pengunjung semua usia.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1471922694854-ff1b63b20054?w=800&q=80',
        ],
        [
            'title'       => 'Pemandangan Bukit Sekitar Danau',
            'description' => 'Perbukitan hijau yang mengelilingi kawasan Danau Toba.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80',
        ],
        [
            'title'       => 'Area Bermain Anak',
            'description' => 'Fasilitas bermain anak yang aman dan menyenangkan.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1575783970733-1aaedde1db74?w=800&q=80',
        ],
        [
            'title'       => 'Dermaga Wisata',
            'description' => 'Dermaga tempat pengunjung naik dan turun perahu wisata.',
            'type'        => 'photo',
            'url'         => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800&q=80',
        ],
    ];

    public function run(): void
    {
        foreach ($this->items as $i => $item) {
            $this->command->info("Downloading gallery image " . ($i + 1) . " of " . count($this->items) . "...");
            $path = $this->downloadImage($item['url'], 'galleries');

            Gallery::create([
                'title'       => $item['title'],
                'slug'        => Str::slug($item['title']) . '-' . Str::random(4),
                'description' => $item['description'],
                'file_path'   => $path ?? 'galleries/placeholder.jpg',
                'type'        => $item['type'],
                'status'      => 'published',
            ]);
        }
    }
}
