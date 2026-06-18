<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            DummyVisitorSeeder::class,
            ProfileSeeder::class,
            ContactSeeder::class,
            FaqSeeder::class,
            ReviewSeeder::class,
            InformationRequestSeeder::class,
        ]);
    }
}
