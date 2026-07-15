<?php

namespace Database\Factories;

use App\Models\AcademicLevel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'academic_level_id' => AcademicLevel::factory(),
            'registration_number' => 'STU-' . $this->faker->unique()->numerify('######'),
            'date_of_birth' => $this->faker->dateTimeBetween('-20 years', '-6 years'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'special_needs' => null,
            'medical_conditions' => null,
            'is_active' => true,
        ];
    }
}
