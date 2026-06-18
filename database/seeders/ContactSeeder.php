<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::create([
            'address' => 'Pantai Pasir Putih Parparean, Desa Parparean II, Kecamatan Porsea, Kabupaten Toba, Sumatera Utara',
            'email' => 'info@pasirputihparparean.test',
            'phone' => '081234567890',
            'google_maps_embed' => '',
            'instagram' => 'https://instagram.com/pasirputihparparean',
            'facebook' => 'https://facebook.com/pasirputihparparean',
            'youtube' => '',
            'twitter' => '',
            'is_active' => true,
        ]);
    }
}
