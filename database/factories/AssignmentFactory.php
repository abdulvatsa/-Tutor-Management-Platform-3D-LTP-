<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Enrollment;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;

    public function definition(): array
    {
        $assignedAt = $this->faker->dateTimeBetween('-7 days', 'now');
        $dueDate = $this->faker->dateTimeBetween($assignedAt, '+14 days');

        return [
            'enrollment_id' => Enrollment::factory(),
            'teacher_id' => Teacher::factory(),
            'title' => $this->faker->sentence(),
            'description' => $this->faker->text(300),
            'instructions' => $this->faker->text(200),
            'assigned_at' => $assignedAt,
            'due_date' => $dueDate,
            'late_submission_deadline' => $this->faker->dateTimeBetween($dueDate, '+3 days'),
            'max_score' => 100,
            'rubric' => null,
            'attachment' => null,
            'status' => 'published',
            'allows_late_submission' => true,
        ];
    }
}
