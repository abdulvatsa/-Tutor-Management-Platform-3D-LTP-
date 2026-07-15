<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            // User management
            'view users', 'create users', 'edit users', 'delete users',
            // Student management
            'view students', 'create students', 'edit students', 'delete students',
            // Teacher management
            'view teachers', 'create teachers', 'edit teachers', 'delete teachers',
            // Enrollment management
            'view enrollments', 'create enrollments', 'edit enrollments', 'delete enrollments',
            // Class sessions
            'view sessions', 'create sessions', 'edit sessions', 'delete sessions',
            // Assignments
            'view assignments', 'create assignments', 'edit assignments', 'delete assignments',
            // Quizzes
            'view quizzes', 'create quizzes', 'edit quizzes', 'delete quizzes',
            // Evaluations
            'view evaluations', 'create evaluations', 'edit evaluations', 'delete evaluations',
            // Reports
            'view reports', 'export reports',
            // System
            'manage settings', 'view audit logs', 'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Define roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacherPermissions = [
            'view students', 'view enrollments', 'create sessions', 'edit sessions',
            'create assignments', 'edit assignments', 'view assignments',
            'create quizzes', 'edit quizzes', 'view quizzes',
            'create evaluations', 'edit evaluations', 'view evaluations',
            'view reports',
        ];
        $teacherRole->syncPermissions(Permission::whereIn('name', $teacherPermissions)->get());

        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $studentPermissions = [
            'view enrollments', 'view sessions', 'view assignments', 'view quizzes', 'view reports',
        ];
        $studentRole->syncPermissions(Permission::whereIn('name', $studentPermissions)->get());

        $parentRole = Role::firstOrCreate(['name' => 'parent', 'guard_name' => 'web']);
        $parentPermissions = [
            'view enrollments', 'view reports',
        ];
        $parentRole->syncPermissions(Permission::whereIn('name', $parentPermissions)->get());
    }
}
