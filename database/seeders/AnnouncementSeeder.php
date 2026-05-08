<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    use ImageSeederHelper;

    private array $announcements = [
        [
            'title'       => 'Festival Danau Toba 2026',
            'content'     => 'Dalam rangka memperingati Hari Jadi Kabupaten Toba, Pantai Pasir Putih Toba akan menyelenggarakan Festival Danau Toba 2026. Acara ini akan menampilkan pertunjukan seni budaya Batak, lomba perahu tradisional, pameran kuliner khas, dan berbagai hiburan menarik lainnya. Festival akan berlangsung selama tiga hari dan terbuka untuk umum.',
            'type'        => 'event',
            'starts_at'   => '2026-06-01 08:00:00',
            'ends_at'     => '2026-06-03 22:00:00',
            'is_active'   => true,
            'is_featured' => true,
            'url'         => 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?w=800&q=80',
        ],
        [
            'title'       => 'Promo Tiket Masuk Akhir Pekan',
            'content'     => 'Dapatkan diskon spesial 30% untuk tiket masuk setiap Sabtu dan Minggu selama bulan Mei 2026. Promo berlaku untuk semua kategori pengunjung. Cukup tunjukkan bukti pembelian tiket online untuk mendapatkan potongan harga. Jangan lewatkan kesempatan liburan hemat bersama keluarga!',
            'type'        => 'promo',
            'starts_at'   => '2026-05-01 00:00:00',
            'ends_at'     => '2026-05-31 23:59:00',
            'is_active'   => true,
            'is_featured' => false,
            'url'         => 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800&q=80',
        ],
        [
            'title'       => 'Perbaikan Dermaga Wisata',
            'content'     => 'Kami informasikan bahwa dermaga wisata sedang dalam proses perbaikan dan peningkatan fasilitas. Selama proses perbaikan, layanan sewa perahu tetap beroperasi namun dengan kapasitas terbatas. Kami mohon maaf atas ketidaknyamanan yang ditimbulkan. Perbaikan dijadwalkan selesai pada akhir bulan April 2026.',
            'type'        => 'info',
            'starts_at'   => '2026-04-10 08:00:00',
            'ends_at'     => '2026-04-30 17:00:00',
            'is_active'   => true,
            'is_featured' => false,
            'url'         => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
        ],
        [
            'title'       => 'Jam Operasional Lebaran 2026',
            'content'     => 'Dalam rangka menyambut Hari Raya Idul Fitri 1447 H, Pantai Pasir Putih Toba akan beroperasi dengan jam khusus. Pada tanggal 30 Maret dan 1 April 2026 kawasan wisata tutup untuk umum. Mulai 2 April 2026, kami kembali buka normal pukul 07.00 - 18.00 WIB. Selamat Hari Raya Idul Fitri, mohon maaf lahir dan batin.',
            'type'        => 'info',
            'starts_at'   => '2026-03-28 00:00:00',
            'ends_at'     => '2026-04-05 23:59:00',
            'is_active'   => true,
            'is_featured' => false,
            'url'         => null,
        ],
        [
            'title'       => 'Pembukaan Wahana Baru: Banana Boat',
            'content'     => 'Kami dengan bangga mengumumkan hadirnya wahana baru di Pantai Pasir Putih Toba yaitu Banana Boat! Wahana ini dapat dinikmati oleh 4-6 orang sekaligus dan cocok untuk semua usia. Harga sewa sangat terjangkau. Segera kunjungi kami dan rasakan sensasi memacu adrenalin di atas Danau Toba!',
            'type'        => 'event',
            'starts_at'   => '2026-05-15 08:00:00',
            'ends_at'     => null,
            'is_active'   => true,
            'is_featured' => true,
            'url'         => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800&q=80',
        ],
    ];

    public function run(): void
    {
        foreach ($this->announcements as $i => $item) {
            $photoPath = null;
            if ($item['url']) {
                $this->command->info("Downloading announcement image " . ($i + 1) . "...");
                $photoPath = $this->downloadImage($item['url'], 'announcements');
            }

            Announcement::create([
                'title'           => $item['title'],
                'slug'            => Str::slug($item['title']) . '-' . Str::random(4),
                'content'         => $item['content'],
                'type'            => $item['type'],
                'starts_at'       => $item['starts_at'],
                'ends_at'         => $item['ends_at'],
                'photo_path'      => $photoPath,
                'attachment_path' => null,
                'is_active'       => $item['is_active'],
                'is_featured'     => $item['is_featured'],
                'views'           => rand(10, 300),
            ]);
        }
    }
}
