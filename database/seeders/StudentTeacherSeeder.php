<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentModel;
use App\Models\User;

class StudentTeacherSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 teachers
        $teachers = User::factory(5)
            ->create()
            ->each(function ($user) {
                $user->assignRole('teacher');
                Teacher::factory()->create(['user_id' => $user->id]);
            });

        // Create 10 students
        $students = User::factory(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole('student');
                Student::factory()->create(['user_id' => $user->id]);
            });

        // Create 5 parents
        $parents = User::factory(5)
            ->create()
            ->each(function ($user) {
                $user->assignRole('parent');
                ParentModel::factory()->create(['user_id' => $user->id]);
            });

        // Associate students with parents
        foreach ($students as $student) {
            $numParents = rand(1, 2);
            $randomParents = $parents->random($numParents)->pluck('id');
            $student->students()->attach(Student::where('user_id', $student->id)->first()->id);
        }
    }
}
