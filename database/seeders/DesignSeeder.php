<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\Profile;
use App\Models\Stat;
use App\Models\HeroImage;
use App\Models\Proyecto;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Award;
use App\Models\Logo;
use App\Models\Section;

class DesignSeeder extends Seeder
{
    public function run()
    {
        // 1. Settings
        $settings = [
            ['key' => 'page_title', 'value' => 'Daniel Stephan - Portfolio'],
            ['key' => 'header_logo_text', 'value' => 'DanielStephan'],
            ['key' => 'hero_tag', 'value' => 'START NEW PROJECT'],
            ['key' => 'hero_title', 'value' => "Talk is cheap.\nShow me the code."],
            ['key' => 'hero_subtitle', 'value' => 'I design and code beautifully simple things, and I love what I do.'],
            ['key' => 'hero_cta_button_text', 'value' => "LET'S CHAT!"],
            ['key' => 'hero_cta_button_target', 'value' => 'contacts'],
            ['key' => 'footer_text', 'value' => 'Let\'s make something amazing together.'],
            ['key' => 'footer_email', 'value' => 'hello@danielstephan.com'],
            ['key' => 'footer_phone', 'value' => '+1 234 567 890'],
            // Menu items
            ['key' => 'menu_home_label', 'value' => 'Home'],
            ['key' => 'menu_services_label', 'value' => 'Services'],
            ['key' => 'menu_works_label', 'value' => 'Works'],
            ['key' => 'menu_about_label', 'value' => 'About'],
            ['key' => 'menu_contact_label', 'value' => 'Contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }

        // 2. Profile
        Profile::truncate();
        Profile::create([
            'name' => 'Daniel Stephan',
            'bio' => "Since beginning my journey as a freelance designer nearly 8 years ago, I've done remote work for agencies, consulted for startups, and collaborated with talented people to create digital products for both business and consumer use.\n\nI'm quietly confident, naturally curious, and perpetually working on improving my chops one design problem at a time.",
            'profile_picture_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?fit=crop&w=300&h=300',
        ]);

        // 3. Stats
        Stat::truncate();
        $stats = [
            ['label' => 'YEARS EXPERIENCE', 'value' => 12, 'orden' => 1],
            ['label' => 'PROJECTS COMPLETED', 'value' => 165, 'orden' => 2],
        ];
        foreach ($stats as $stat) {
            Stat::create($stat);
        }

        // 4. Hero Images
        $heroImages = [
            [
                'type' => 'central',
                'image_url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?fit=crop&w=600&h=800',
                'required_size' => '600x800',
                'description' => 'Main developer image'
            ],
            [
                'type' => 'icon_angular',
                'image_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/angularjs/angularjs-original.svg',
                'required_size' => '64x64',
                'description' => 'Floating Icon 1'
            ],
            [
                'type' => 'icon_js',
                'image_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg',
                'required_size' => '64x64',
                'description' => 'Floating Icon 2'
            ],
            [
                'type' => 'icon_python',
                'image_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg',
                'required_size' => '64x64',
                'description' => 'Floating Icon 3'
            ],
        ];

        foreach ($heroImages as $img) {
            HeroImage::updateOrCreate(['type' => $img['type']], $img);
        }

        // 5. Projects
        Proyecto::truncate();
        $proyectos = [
            [
                'titulo' => 'Lewis',
                'descripcion' => 'Lewis Creativity Studio - A dark themed creative agency website.',
                'imagen_url' => 'https://images.unsplash.com/photo-1600607686527-6fb886090705?fit=crop&w=800&h=600',
                'url_proyecto' => '#',
                'tecnologias' => ['React', 'GSAP', 'WebGL'],
                'orden' => 1,
                'destacado' => true
            ],
            [
                'titulo' => 'Fineco',
                'descripcion' => 'Finance Dashboard - Fintech application for managing personal assets.',
                'imagen_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?fit=crop&w=800&h=600',
                'url_proyecto' => '#',
                'tecnologias' => ['Vue', 'D3.js', 'Laravel'],
                'orden' => 2,
                'destacado' => true
            ],
            [
                'titulo' => 'Focus',
                'descripcion' => 'Get your things done, stay under control. Productivity app landing page.',
                'imagen_url' => 'https://images.unsplash.com/photo-1481487484168-9b930d5b7d9d?fit=crop&w=800&h=600',
                'url_proyecto' => '#',
                'tecnologias' => ['Next.js', 'Tailwind', 'Supabase'],
                'orden' => 3,
                'destacado' => true
            ],
        ];

        foreach ($proyectos as $proyecto) {
            Proyecto::create($proyecto);
        }

        // 6. Services
        Service::truncate();
        $services = [
            ['title' => 'Design', 'description' => 'I create beautiful and functional user interfaces.', 'icon' => '🎨', 'orden' => 1],
            ['title' => 'Front-End', 'description' => 'I build responsive and interactive web applications.', 'icon' => '💻', 'orden' => 2],
            ['title' => 'SEO', 'description' => 'I optimize websites for search engines.', 'icon' => '🚀', 'orden' => 3],
        ];
        foreach ($services as $service) {
            Service::create($service);
        }

        // 7. Testimonials
        Testimonial::truncate();
        Testimonial::create([
            'name' => 'Sarah Johnson',
            'role' => 'CEO at TechStart',
            'quote' => 'Daniel is an exceptional developer who delivered our project on time and exceeded our expectations.',
            'rating' => 5,
            'avatar_url' => 'https://randomuser.me/api/portraits/women/44.jpg',
            'orden' => 1
        ]);

        // 8. Awards
        Award::truncate();
        $awards = [
            ['year' => '2023', 'title' => 'Site of the Day', 'project' => 'Lewis Studio', 'category' => 'Awwwards', 'orden' => 1],
            ['year' => '2022', 'title' => 'Best UI Design', 'project' => 'Fineco App', 'category' => 'Behance', 'orden' => 2],
        ];
        foreach ($awards as $award) {
            Award::create($award);
        }

        // 9. Logos
        Logo::truncate();
        $logos = [
            ['name' => 'Google', 'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg', 'orden' => 1],
            ['name' => 'Airbnb', 'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/6/69/Airbnb_Logo_B%C3%A9lo.svg', 'orden' => 2],
            ['name' => 'Stripe', 'image_url' => 'https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg', 'orden' => 3],
        ];
        foreach ($logos as $logo) {
            Logo::create($logo);
        }

        // 10. Sections (Visibility)
        Section::truncate();
        $sections = [
            ['name' => 'Hero Section', 'slug' => 'hero', 'active' => true, 'orden' => 1],
            ['name' => 'Services Section', 'slug' => 'services', 'active' => true, 'orden' => 2],
            ['name' => 'Logos Section', 'slug' => 'logos', 'active' => true, 'orden' => 3],
            ['name' => 'Works Section', 'slug' => 'works', 'active' => true, 'orden' => 4],
            ['name' => 'Testimonials Section', 'slug' => 'testimonials', 'active' => true, 'orden' => 5],
            ['name' => 'Awards Section', 'slug' => 'awards', 'active' => true, 'orden' => 6],
            ['name' => 'Footer', 'slug' => 'footer', 'active' => true, 'orden' => 7],
        ];
        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
