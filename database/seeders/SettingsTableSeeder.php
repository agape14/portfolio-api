<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'page_title',
                'value' => 'Portafolio - Daniel Stephan',
            ],
            [
                'key' => 'hero_tag',
                'value' => 'Your real developer.',
            ],
            [
                'key' => 'hero_title',
                'value' => 'Talk is cheap. Show me the code.',
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'I design and code beautifully simple things, and I love what I do.',
            ],
            [
                'key' => 'header_logo_text',
                'value' => 'Daniel Stephan',
            ],
            [
                'key' => 'header_menu_services',
                'value' => 'Services',
            ],
            [
                'key' => 'header_menu_works',
                'value' => 'Works',
            ],
            [
                'key' => 'header_menu_notes',
                'value' => 'Notes',
            ],
            [
                'key' => 'header_menu_contacts',
                'value' => 'Contacts',
            ],
            [
                'key' => 'hero_cta_button_text',
                'value' => "LET'S CHAT!",
            ],
            [
                'key' => 'hero_cta_button_target',
                'value' => 'contacts',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
