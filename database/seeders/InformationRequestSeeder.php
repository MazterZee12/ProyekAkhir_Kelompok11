<?php

namespace Database\Seeders;

use App\Models\InformationRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class InformationRequestSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            return;
        }

        $requests = [
            [
                'subject' => 'Jam Operasional Pantai',
                'message' => 'Selamat pagi. Saya berencana berkunjung bersama keluarga pada akhir pekan ini. Mohon informasi mengenai jam operasional Pantai Pasir Putih Parparean dan apakah tetap buka pada hari libur nasional.',
                'response' => 'Pantai Pasir Putih Parparean buka setiap hari mulai pukul 08.00 hingga 18.00 WIB, termasuk pada hari libur nasional.',
                'status' => InformationRequest::STATUS_ANSWERED,
            ],

            [
                'subject' => 'Harga Tiket Masuk Terbaru',
                'message' => 'Apakah ada perubahan harga tiket masuk untuk dewasa dan anak-anak pada tahun ini? Saya ingin memastikan biaya sebelum berkunjung.',
                'response' => 'Harga tiket masuk saat ini masih sesuai dengan informasi yang tersedia pada halaman harga. Silakan melihat menu harga untuk detail terbaru.',
                'status' => InformationRequest::STATUS_ANSWERED,
            ],

            [
                'subject' => 'Penyewaan Gazebo',
                'message' => 'Apakah tersedia gazebo yang dapat disewa untuk acara keluarga kecil? Jika tersedia, berapa kapasitas dan biaya sewanya?',
                'response' => null,
                'status' => InformationRequest::STATUS_PENDING,
            ],

            [
                'subject' => 'Area Parkir Bus Pariwisata',
                'message' => 'Rombongan kami berencana menggunakan bus pariwisata berkapasitas besar. Apakah area parkir dapat menampung kendaraan tersebut?',
                'response' => 'Tersedia area parkir yang cukup luas untuk kendaraan pribadi maupun bus pariwisata.',
                'status' => InformationRequest::STATUS_ANSWERED,
            ],

            [
                'subject' => 'Ketersediaan Kamar Bilas',
                'message' => 'Apakah di kawasan pantai tersedia kamar mandi dan kamar bilas yang dapat digunakan setelah berenang?',
                'response' => 'Ya, tersedia kamar mandi dan kamar bilas yang dapat digunakan oleh pengunjung selama jam operasional.',
                'status' => InformationRequest::STATUS_ANSWERED,
            ],

            [
                'subject' => 'Reservasi untuk Acara Komunitas',
                'message' => 'Kami dari komunitas fotografi ingin mengadakan kegiatan gathering di lokasi pantai. Apakah diperlukan izin atau reservasi terlebih dahulu?',
                'response' => null,
                'status' => InformationRequest::STATUS_PENDING,
            ],

            [
                'subject' => 'Akses Kendaraan Roda Dua',
                'message' => 'Apakah akses jalan menuju lokasi pantai aman dan mudah dilalui menggunakan sepeda motor?',
                'response' => 'Akses menuju lokasi cukup baik dan dapat dilalui kendaraan roda dua maupun roda empat.',
                'status' => InformationRequest::STATUS_ANSWERED,
            ],

            [
                'subject' => 'Fasilitas Mushola',
                'message' => 'Saya ingin mengetahui apakah tersedia mushola atau tempat ibadah bagi pengunjung di area wisata.',
                'response' => null,
                'status' => InformationRequest::STATUS_PENDING,
            ],

            [
                'subject' => 'Kegiatan Camping',
                'message' => 'Apakah pengunjung diperbolehkan mendirikan tenda dan menginap di sekitar kawasan pantai?',
                'response' => 'Untuk kegiatan camping, silakan menghubungi pengelola terlebih dahulu guna mendapatkan informasi dan izin yang diperlukan.',
                'status' => InformationRequest::STATUS_ANSWERED,
            ],

            [
                'subject' => 'Wisata Edukasi Sekolah',
                'message' => 'Sekolah kami berencana mengadakan kunjungan edukasi ke Danau Toba dan Pantai Pasir Putih Parparean. Apakah tersedia paket kunjungan khusus untuk rombongan pelajar?',
                'response' => null,
                'status' => InformationRequest::STATUS_PENDING,
            ],
        ];

        foreach ($requests as $request) {
            InformationRequest::create([
                'user_id' => $users->random()->id,
                'subject' => $request['subject'],
                'message' => $request['message'],
                'response' => $request['response'],
                'status' => $request['status'],
                'responded_at' => $request['status'] === InformationRequest::STATUS_ANSWERED
                    ? now()->subDays(rand(1, 30))
                    : null,
            ]);
        }
    }
}
