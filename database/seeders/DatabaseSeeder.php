<?php

namespace Database\Seeders;

use Illuminate\Container\Attributes\Database;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            ScheduleSeeder::class,
        ]);
    }
}
