<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            UserAndReviewSeeder::class,
            ProfileSeeder::class,
            ContactSeeder::class,
            FacilitySeeder::class,
            PriceSeeder::class,
            AnnouncementSeeder::class,
            ScheduleSeeder::class,
            FaqSeeder::class,
            GallerySeeder::class,
            BannerSeeder::class,
        ]);
    }
}
