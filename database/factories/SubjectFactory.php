<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use App\Models\Subject;
use App\Models\SubjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        $subjects = ['Mathematics', 'English', 'Science', 'History', 'Geography', 'Physics', 'Chemistry', 'Biology', 'Computer Science', 'Economics'];

        return [
            'category_id' => SubjectCategory::factory(),
            'academic_level_id' => AcademicLevel::factory(),
            'name' => $this->faker->randomElement($subjects),
            'code' => $this->faker->unique()->bothify('SUB-###'),
            'description' => $this->faker->text(200),
            'color' => $this->faker->colorName(),
            'display_order' => $this->faker->numberBetween(1, 20),
            'is_active' => true,
        ];
    }
}
