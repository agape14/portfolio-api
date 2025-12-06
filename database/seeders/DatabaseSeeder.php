<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ContentSeeder::class,
            HeroImagesTableSeeder::class,
            // Add other seeders here if needed
            // DesignSeeder::class, 
            // HeroImagesTableSeeder::class,
            // etc.
        ]);
    }
}
