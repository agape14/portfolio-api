<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'bio' => "I'm a passionate developer with over 12 years of experience creating beautiful and functional web applications. I specialize in front-end development, user experience design, and creating seamless interactions between design and code.\n\nMy approach combines technical expertise with creative problem-solving, always focusing on delivering solutions that are both visually stunning and highly functional. I believe in writing clean, maintainable code and staying up-to-date with the latest technologies and best practices.\n\nWhen I'm not coding, you can find me exploring new design trends, contributing to open-source projects, or sharing knowledge with the developer community.",
                'profile_picture_url' => null,
            ]
        );
    }
}
