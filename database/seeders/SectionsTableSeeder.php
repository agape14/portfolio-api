<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            [
                'name' => 'Header',
                'slug' => 'header',
                'active' => true,
                'orden' => 1,
            ],
            [
                'name' => 'Hero Section',
                'slug' => 'hero',
                'active' => true,
                'orden' => 2,
            ],
            [
                'name' => 'Estadísticas',
                'slug' => 'stats',
                'active' => true,
                'orden' => 3,
            ],
            [
                'name' => 'Acerca de Mí',
                'slug' => 'about',
                'active' => false,
                'orden' => 4,
            ],
            [
                'name' => 'Últimos Trabajos',
                'slug' => 'works',
                'active' => false,
                'orden' => 5,
            ],
            [
                'name' => 'Services',
                'slug' => 'services',
                'active' => false,
                'orden' => 6,
            ],
            [
                'name' => 'Notes',
                'slug' => 'notes',
                'active' => false,
                'orden' => 7,
            ],
            [
                'name' => 'Contacts',
                'slug' => 'contacts',
                'active' => false,
                'orden' => 8,
            ],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(
                ['slug' => $section['slug']],
                $section
            );
        }
    }
}
