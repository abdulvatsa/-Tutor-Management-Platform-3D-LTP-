<?php

namespace Database\Factories;

use App\Models\ClassSession;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassSessionFactory extends Factory
{
    protected $model = ClassSession::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('now', '+30 days');
        $end = (clone $start)->modify('+60 minutes');

        return [
            'enrollment_id' => Enrollment::factory(),
            'scheduled_start' => $start,
            'scheduled_end' => $end,
            'actual_start' => null,
            'actual_end' => null,
            'google_meet_link' => null,
            'meeting_code' => null,
            'status' => 'scheduled',
            'notes' => $this->faker->text(200),
            'session_summary' => null,
            'recording_url' => null,
        ];
    }
}
