<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::create([
            'address'           => 'Desa Pardamean Sibisa, Kecamatan Ajibata, Kabupaten Toba, Sumatera Utara 22384',
            'email'             => 'info@pasirputihtoba.com',
            'phone'             => '+62 812-3456-7890',
            'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15932.123456789!2d99.0!3d2.6!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMsKwMzYnMDAuMCJOIDk5wrAwMCcwMC4wIkU!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'instagram'         => 'https://instagram.com/pasirputihtoba',
            'facebook'          => 'https://facebook.com/pasirputihtoba',
            'youtube'           => 'https://youtube.com/@pasirputihtoba',
            'twitter'           => null,
            'is_active'         => true,
            'views'             => 0,
        ]);
    }
}
