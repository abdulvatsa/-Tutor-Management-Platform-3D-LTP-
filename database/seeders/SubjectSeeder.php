<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\AcademicLevel;
use App\Models\SubjectCategory;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH', 'category' => 'Mathematics', 'color' => 'blue'],
            ['name' => 'English', 'code' => 'ENG', 'category' => 'Languages', 'color' => 'green'],
            ['name' => 'Physics', 'code' => 'PHY', 'category' => 'Sciences', 'color' => 'red'],
            ['name' => 'Chemistry', 'code' => 'CHEM', 'category' => 'Sciences', 'color' => 'purple'],
            ['name' => 'Biology', 'code' => 'BIO', 'category' => 'Sciences', 'color' => 'green'],
            ['name' => 'History', 'code' => 'HIST', 'category' => 'Social Studies', 'color' => 'brown'],
            ['name' => 'Geography', 'code' => 'GEO', 'category' => 'Social Studies', 'color' => 'orange'],
            ['name' => 'Computer Science', 'code' => 'CS', 'category' => 'Technology', 'color' => 'gray'],
            ['name' => 'Spanish', 'code' => 'SPAN', 'category' => 'Languages', 'color' => 'yellow'],
            ['name' => 'French', 'code' => 'FREN', 'category' => 'Languages', 'color' => 'navy'],
        ];

        $academicLevel = AcademicLevel::first();

        foreach ($subjects as $index => $subject) {
            $category = SubjectCategory::where('name', $subject['category'])->first();

            Subject::firstOrCreate(
                ['code' => $subject['code']],
                [
                    'name' => $subject['name'],
                    'category_id' => $category?->id,
                    'academic_level_id' => $academicLevel?->id,
                    'description' => "Study of {$subject['name']}",
                    'color' => $subject['color'],
                    'display_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
