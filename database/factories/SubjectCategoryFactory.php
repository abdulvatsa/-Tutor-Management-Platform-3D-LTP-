<?php

namespace Database\Factories;

use App\Models\SubjectCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SubjectCategoryFactory extends Factory
{
    protected $model = SubjectCategory::class;

    public function definition(): array
    {
        $name = $this->faker->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(200),
            'icon' => 'book',
            'display_order' => $this->faker->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
