<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AcademicLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-3 months', 'now');
        $endDate = $this->faker->dateTimeBetween($startDate, '+6 months');

        return [
            'student_id' => Student::factory(),
            'teacher_id' => Teacher::factory(),
            'subject_id' => Subject::factory(),
            'academic_level_id' => AcademicLevel::factory(),
            'reference_number' => 'ENR-' . $this->faker->unique()->numerify('########'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_hours' => $this->faker->numberBetween(10, 100),
            'sessions_per_week' => $this->faker->numberBetween(1, 5),
            'session_duration' => $this->faker->randomElement(['30', '45', '60', '90']),
            'class_type' => $this->faker->randomElement(['one_on_one', 'small_group', 'online']),
            'hourly_rate' => $this->faker->numberBetween(15, 100),
            'total_fees' => null,
            'learning_goals' => $this->faker->text(300),
            'special_requirements' => null,
            'status' => 'active',
        ];
    }
}
