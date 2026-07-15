<?php

namespace Database\Factories;

use App\Models\TeacherTimesheet;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherTimesheetFactory extends Factory
{
    protected $model = TeacherTimesheet::class;

    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'timesheet_year' => now()->year,
            'timesheet_month' => now()->month,
            'total_hours' => $this->faker->numberBetween(20, 160),
            'total_amount' => 0,
            'status' => 'draft',
            'submitted_at' => null,
            'approved_at' => null,
            'approved_by' => null,
            'approval_notes' => null,
            'paid_at' => null,
            'payment_reference' => null,
        ];
    }
}
