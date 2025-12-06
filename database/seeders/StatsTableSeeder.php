<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stat;

class StatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stats = [
            [
                'label' => 'YEARS EXPERIENCE',
                'value' => 12,
                'orden' => 1,
            ],
            [
                'label' => 'PROJECTS COMPLETED ON 18 COUNTRIES',
                'value' => 165,
                'orden' => 2,
            ],
        ];

        foreach ($stats as $stat) {
            Stat::updateOrCreate(
                ['label' => $stat['label']],
                $stat
            );
        }
    }
}
