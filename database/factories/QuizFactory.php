<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Enrollment;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+30 days');
        $endDate = $this->faker->dateTimeBetween($startDate, '+60 days');

        return [
            'enrollment_id' => Enrollment::factory(),
            'teacher_id' => Teacher::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(300),
            'total_questions' => 0,
            'max_score' => 100,
            'time_limit_minutes' => $this->faker->numberBetween(30, 120),
            'show_correct_answers' => true,
            'shuffle_questions' => false,
            'shuffle_options' => false,
            'status' => 'published',
            'starts_at' => $startDate,
            'ends_at' => $endDate,
        ];
    }
}
