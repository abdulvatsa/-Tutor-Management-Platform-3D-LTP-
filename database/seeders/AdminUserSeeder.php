<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@tutorplatform.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');

        // Create sample teacher
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@tutorplatform.com'],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone' => '+1234567891',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $teacher->assignRole('teacher');

        // Create sample student
        $student = User::firstOrCreate(
            ['email' => 'student@tutorplatform.com'],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'phone' => '+1234567892',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $student->assignRole('student');

        // Create sample parent
        $parent = User::firstOrCreate(
            ['email' => 'parent@tutorplatform.com'],
            [
                'first_name' => 'Robert',
                'last_name' => 'Johnson',
                'phone' => '+1234567893',
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $parent->assignRole('parent');
    }
}
