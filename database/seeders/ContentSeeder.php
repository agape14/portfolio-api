<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Stat;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\Award;
use App\Models\Client;
use App\Models\Service;

class ContentSeeder extends Seeder
{
    public function run()
    {
        // Settings
        $settings = [
            'hero_badge' => 'Desarrollador Web',
            'hero_title' => 'Hablar es barato.<br>Muéstrame el código',
            'hero_subtitle' => 'Diseño y desarrollo experiencias digitales limpias, rápidas y fáciles de usar.',
            'about_title' => 'Hola, soy Agapito De la Cruz',
            'about_text_1' => 'Desarrollador y diseñador de interfaces enfocado en crear productos digitales claros, consistentes y escalables.',
            'about_text_2' => 'Trabajo con equipos y startups construyendo aplicaciones, dashboards y sitios que combinan buen diseño con código sólido.',
            'footer_text_left' => 'Hagamos algo increíble juntos.',
            'footer_email' => 'agapito@tudominio.com',
            'footer_location' => 'Tu ciudad, país',
        ];

        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        // Stats
        Stat::truncate();
        Stat::create(['value' => 12, 'label' => 'Años<br>experiencia', 'orden' => 1]);
        Stat::create(['value' => 165, 'label' => 'Proyectos<br>completados', 'orden' => 2]);

        // Skills
        Skill::truncate();
        Skill::create(['name' => 'Diseño', 'description' => 'Creo interfaces limpias y modernas para web y móvil.', 'order' => 1]);
        Skill::create(['name' => 'Front-End', 'description' => 'Maqueto interfaces con HTML, CSS y JavaScript modernos.', 'order' => 2]);
        Skill::create(['name' => 'SEO', 'description' => 'Optimización técnica para mejor rendimiento y posicionamiento.', 'order' => 3]);

        // Projects
        Project::truncate();
        Project::create([
            'title' => 'Estudio Creativo Lewis',
            'description' => 'Landing page para un estudio creativo.',
            'image_url' => 'work-lewis.jpg',
            'featured' => true,
            'order' => 1
        ]);
        Project::create([
            'title' => 'Panel Finaco',
            'description' => 'Dashboard financiero con métricas en tiempo real.',
            'image_url' => 'work-finaco.jpg',
            'featured' => true,
            'order' => 2
        ]);
        Project::create([
            'title' => 'Aplicación Focus',
            'description' => 'Aplicación web para gestionar tareas y productividad.',
            'image_url' => 'work-focus.jpg',
            'featured' => true,
            'order' => 3
        ]);

        // Testimonials
        Testimonial::truncate();
        Testimonial::create([
            'name' => 'Jane Doe',
            'role' => 'Product Manager',
            'quote' => 'Agapito fue un placer para trabajar, entregó a tiempo y superó las expectativas en calidad y detalle.',
            'orden' => 1
        ]);

        // Awards
        Award::truncate();
        Award::create(['year' => '2018', 'title' => 'Mejor proyecto', 'project' => 'Focus', 'category' => 'Development', 'orden' => 1]);
        Award::create(['year' => '2018', 'title' => 'Responsabilidad Social Corporativa', 'project' => 'Arquito', 'category' => 'Social', 'orden' => 2]);
        Award::create(['year' => '2017', 'title' => 'Sitio del año', 'project' => 'Lewis', 'category' => 'Design', 'orden' => 3]);

        // Clients (New)
        Client::truncate();
        Client::create(['name' => 'Client 1', 'logo_url' => 'client1.png', 'order' => 1]);
        Client::create(['name' => 'Client 2', 'logo_url' => 'client2.png', 'order' => 2]);
        Client::create(['name' => 'Client 3', 'logo_url' => 'client3.png', 'order' => 3]);

        // Services
        Service::truncate();
        Service::create([
            'title' => 'Desarrollo Web',
            'description' => 'Sitios web modernos, rápidos y responsivos construidos con las últimas tecnologías como React y Laravel.',
            'icon' => '💻',
            'orden' => 1
        ]);
        Service::create([
            'title' => 'Diseño UI/UX',
            'description' => 'Interfaces intuitivas y atractivas que mejoran la experiencia del usuario y la conversión.',
            'icon' => '🎨',
            'orden' => 2
        ]);
        Service::create([
            'title' => 'Optimización SEO',
            'description' => 'Mejora la visibilidad de tu sitio en los motores de búsqueda para atraer más tráfico orgánico.',
            'icon' => '🚀',
            'orden' => 3
        ]);
    }
}
