<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroImage;

class HeroImagesTextSeeder extends Seeder
{
    public function run()
    {
        // Actualizar el registro main_hero con los textos
        HeroImage::updateOrCreate(
            ['type' => 'main_hero'],
            [
                'badge_text' => 'Listo para crear tu proyecto',
                'title' => "Hablar es\nsencillo.\nMuéstrame el\ncódigo.",
                'subtitle' => "Since beginning my journey as a freelance designer nearly 8 years ago, I've done remote work for agencies, consulted for startups, and collaborated with talented people to create digital products for both business and consumer use. I'm quietly confident, naturally curious, and perpetually working on improving my chops one design problem at a time.",
                'description' => 'Imagen Central (Persona con Hoodie)',
                'required_size' => '800x800'
            ]
        );

        $this->command->info('Textos del Hero Section agregados correctamente!');
    }
}
