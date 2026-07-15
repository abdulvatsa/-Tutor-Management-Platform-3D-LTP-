<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicLevel;

class AcademicLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'name' => 'Primary',
                'code' => 'PRI',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Secondary',
                'code' => 'SEC',
                'display_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Tertiary',
                'code' => 'TER',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'University',
                'code' => 'UNI',
                'display_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($levels as $level) {
            AcademicLevel::firstOrCreate(
                ['code' => $level['code']],
                $level
            );
        }
    }
}
