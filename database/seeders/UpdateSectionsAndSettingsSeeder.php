<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use App\Models\Setting;

class UpdateSectionsAndSettingsSeeder extends Seeder
{
    public function run()
    {
        // Desactivar todas las secciones primero
        Section::query()->update(['active' => false]);

        // Configurar solo las secciones necesarias
        $sections = [
            [
                'slug' => 'hero',
                'name' => 'Hero Section',
                'active' => true,
                'orden' => 1
            ],
            [
                'slug' => 'services',
                'name' => 'Services',
                'active' => true,
                'orden' => 2
            ],
            [
                'slug' => 'works',
                'name' => 'Works',
                'active' => true,
                'orden' => 3
            ],
            [
                'slug' => 'about',
                'name' => 'About',
                'active' => true,
                'orden' => 4
            ],
            [
                'slug' => 'contact',
                'name' => 'Contact',
                'active' => true,
                'orden' => 5
            ],
            [
                'slug' => 'footer',
                'name' => 'Footer',
                'active' => true,
                'orden' => 6
            ],
        ];

        foreach ($sections as $sectionData) {
            Section::updateOrCreate(
                ['slug' => $sectionData['slug']],
                $sectionData
            );
        }

        // Actualizar settings para los labels del menú
        $settings = [
            // Header
            'header_logo_text' => 'Agapito De la cruz',
            
            // Hero Section
            'hero_title' => 'Hablar es sencillo.\nMuéstrame el código.',
            'hero_subtitle' => 'Diseño y codifico aplicaciones web y me encanta lo que hago.',
            
            // Menu Labels
            'menu_hero_label' => 'Home',
            'menu_services_label' => 'Services',
            'menu_works_label' => 'Works',
            'menu_about_label' => 'About',
            'menu_contact_label' => 'Contact',
            
            // Footer
            'footer_text' => 'Hagamos algo increíble juntos.',
            'footer_email' => 'hello@agapito.io',
            'footer_phone' => '',
            
            // Page Title
            'page_title' => 'Agapito De la cruz - Full Stack Developer',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        $this->command->info('Secciones y configuraciones actualizadas correctamente!');
    }
}
