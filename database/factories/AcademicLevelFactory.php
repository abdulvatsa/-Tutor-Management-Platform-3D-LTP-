<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AcademicLevelFactory extends Factory
{
    public function definition(): array
    {
        $levels = ['Primary', 'Secondary', 'Tertiary', 'University'];
        static $levelIndex = 0;

        $level = $levels[$levelIndex % count($levels)];
        $levelIndex++;

        return [
            'name' => $level,
            'code' => strtoupper(substr($level, 0, 3)),
            'display_order' => $levelIndex,
            'is_active' => true,
        ];
    }
}
