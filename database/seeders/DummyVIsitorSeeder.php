<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyVisitorSeeder extends Seeder
{
    public function run(): void
    {
        $visitors = [
            [
                'name' => 'Andi Saputra',
                'email' => 'andi.siaputra@example.com',
            ],
            [
                'name' => 'Rina Sihotang',
                'email' => 'rina.sihotang@example.com',
            ],
            [
                'name' => 'Budi Simanjuntak',
                'email' => 'budi.simanjuntak@example.com',
            ],
            [
                'name' => 'Maya Siregar',
                'email' => 'maya.siregar@example.com',
            ],
            [
                'name' => 'Doni Hutapea',
                'email' => 'doni.hutapea@example.com',
            ],
            [
                'name' => 'Sinta Harahap',
                'email' => 'sinta.harahap@example.com',
            ],
            [
                'name' => 'Rio Pasaribu',
                'email' => 'rio.pasaribu@example.com',
            ],
            [
                'name' => 'Nia Nainggolan',
                'email' => 'nia.nainggolan@example.com',
            ],
            [
                'name' => 'Toni Marbun',
                'email' => 'toni.marbun@example.com',
            ],
            [
                'name' => 'Lina Manurung',
                'email' => 'lina.manurung@example.com',
            ],
        ];

        foreach ($visitors as $visitor) {
            User::updateOrCreate(
                ['email' => $visitor['email']],
                [
                    'name' => $visitor['name'],
                    'password' => Hash::make('password'),
                    // kalau tabel users kamu punya kolom role, aktifkan ini:
                    // 'role' => 'visitor',
                ]
            );
        }
    }
}
