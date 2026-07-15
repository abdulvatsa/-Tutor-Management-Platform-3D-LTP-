<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'employee_id' => 'EMP-' . $this->faker->unique()->numerify('######'),
            'qualification' => $this->faker->randomElement(['Bachelor', 'Master', 'PhD']),
            'specialization' => $this->faker->word(),
            'years_of_experience' => $this->faker->numberBetween(0, 30),
            'date_of_joining' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'employment_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'hourly_rate' => $this->faker->numberBetween(15, 100),
            'bank_account' => $this->faker->bankAccountNumber(),
            'bank_name' => $this->faker->word(),
            'bio' => $this->faker->text(300),
            'certification' => $this->faker->word(),
            'is_active' => true,
            'is_verified' => false,
        ];
    }
}
