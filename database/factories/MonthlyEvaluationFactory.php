<?php

namespace Database\Factories;

use App\Models\MonthlyEvaluation;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class MonthlyEvaluationFactory extends Factory
{
    protected $model = MonthlyEvaluation::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'teacher_id' => Teacher::factory(),
            'enrollment_id' => Enrollment::factory(),
            'evaluation_year' => now()->year,
            'evaluation_month' => now()->month,
            'academic_progress' => $this->faker->numberBetween(1, 5),
            'academic_progress_comments' => $this->faker->text(200),
            'behaviour_rating' => $this->faker->numberBetween(1, 5),
            'behaviour_comments' => $this->faker->text(200),
            'participation_rating' => $this->faker->numberBetween(1, 5),
            'participation_comments' => $this->faker->text(200),
            'homework_completion' => $this->faker->numberBetween(1, 5),
            'homework_comments' => $this->faker->text(200),
            'communication_rating' => $this->faker->numberBetween(1, 5),
            'communication_comments' => $this->faker->text(200),
            'strengths' => $this->faker->text(200),
            'areas_for_improvement' => $this->faker->text(200),
            'goals_for_next_month' => $this->faker->text(200),
            'teacher_recommendations' => $this->faker->text(200),
            'completed_at' => now(),
            'sent_to_parent' => false,
            'sent_at' => null,
        ];
    }
}
