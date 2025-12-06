<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HeroImage;

class HeroImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            [
                'type' => 'main_hero',
                'image_url' => null,
                'required_size' => '800x1000',
                'description' => 'Imagen central del desarrollador. Tamaño recomendado: 800x1000px (ancho x alto). Formato: PNG, JPG o WebP.',
            ],
            [
                'type' => 'icon_angular',
                'image_url' => null,
                'required_size' => '64x64',
                'description' => 'Icono de Angular. Tamaño recomendado: 64x64px. Formato: PNG con fondo transparente.',
            ],
            [
                'type' => 'icon_js',
                'image_url' => null,
                'required_size' => '64x64',
                'description' => 'Icono de JavaScript. Tamaño recomendado: 64x64px. Formato: PNG con fondo transparente.',
            ],
            [
                'type' => 'icon_python',
                'image_url' => null,
                'required_size' => '64x64',
                'description' => 'Icono de Python. Tamaño recomendado: 64x64px. Formato: PNG con fondo transparente.',
            ],
        ];

        foreach ($images as $image) {
            HeroImage::updateOrCreate(
                ['type' => $image['type']],
                $image
            );
        }
    }
}
