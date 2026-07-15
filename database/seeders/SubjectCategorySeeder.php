<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubjectCategory;
use Illuminate\Support\Str;

class SubjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Languages', 'icon' => 'globe', 'description' => 'Language and communication studies'],
            ['name' => 'Mathematics', 'icon' => 'calculator', 'description' => 'Mathematical sciences and numeracy'],
            ['name' => 'Sciences', 'icon' => 'flask', 'description' => 'Natural sciences and laboratory studies'],
            ['name' => 'Social Studies', 'icon' => 'book', 'description' => 'History, geography, and social sciences'],
            ['name' => 'Technology', 'icon' => 'laptop', 'description' => 'Computer science and digital skills'],
            ['name' => 'Arts', 'icon' => 'palette', 'description' => 'Creative and performing arts'],
        ];

        foreach ($categories as $index => $category) {
            SubjectCategory::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                array_merge($category, [
                    'display_order' => $index + 1,
                    'is_active' => true,
                ])
            );
        }
    }
}
