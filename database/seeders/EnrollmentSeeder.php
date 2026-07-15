<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $teachers = Teacher::all();
        $subjects = Subject::all();

        if ($students->isEmpty() || $teachers->isEmpty() || $subjects->isEmpty()) {
            $this->command->info('Skipping EnrollmentSeeder: Missing required data.');
            return;
        }

        foreach ($students as $student) {
            // Create 1-3 enrollments per student
            $enrollmentCount = rand(1, 3);
            for ($i = 0; $i < $enrollmentCount; $i++) {
                Enrollment::factory()->create([
                    'student_id' => $student->id,
                    'teacher_id' => $teachers->random()->id,
                    'subject_id' => $subjects->random()->id,
                    'academic_level_id' => $student->academic_level_id,
                ]);
            }
        }
    }
}
