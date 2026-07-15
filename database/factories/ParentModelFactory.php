<?php

namespace Database\Factories;

use App\Models\ParentModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParentModelFactory extends Factory
{
    protected $model = ParentModel::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'relationship' => $this->faker->randomElement(['Mother', 'Father', 'Guardian']),
            'occupation' => $this->faker->jobTitle(),
            'company' => $this->faker->company(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'alternative_phone' => $this->faker->phoneNumber(),
            'is_primary_contact' => true,
            'is_active' => true,
        ];
    }
}
