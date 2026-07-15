# Model Policies - Authorization Layer

This directory contains all Laravel authorization policies for the 3D-LTP platform. Policies implement fine-grained access control based on user roles and permissions.

## Policy Structure

Each policy class follows a consistent pattern:

```php
class ModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user): bool
    public function view(User $user, Model $model): bool
    public function create(User $user): bool
    public function update(User $user, Model $model): bool
    public function delete(User $user, Model $model): bool
    public function restore(User $user, Model $model): bool
    public function forceDelete(User $user, Model $model): bool
}
```

## Available Policies

### User Management
- **UserPolicy**: User account management and profile access
- **StudentPolicy**: Student profile and enrollment access
- **TeacherPolicy**: Teacher profile and class management
- **ParentPolicy**: Parent account and child monitoring

### Academic Management
- **EnrollmentPolicy**: Student enrollments and class assignments
- **SubjectPolicy**: Subject management and curriculum

### Teaching & Learning
- **ClassSessionPolicy**: Class scheduling and session management
  - Custom: `markAttendance(User, ClassSession)`
- **AssignmentPolicy**: Assignment creation and grading
  - Custom: `gradeSubmission(User, Assignment)`
- **AttendancePolicy**: Attendance tracking and recording

### Assessment & Evaluation
- **MonthlyEvaluationPolicy**: Student evaluations and reports
  - Custom: `sendToParent(User, MonthlyEvaluation)`

### Operations
- **TeacherTimesheetPolicy**: Teacher timesheet management
  - Custom: `approve(User, TeacherTimesheet)`

### Communication
- **NotificationPolicy**: User notifications
- **MessagePolicy**: Direct messaging between users

## Authorization Rules by Role

### Super Admin
- Full access to all models and operations
- Can view and manage any data across all organizations
- Can perform administrative actions

### Admin
- Full access within their organization
- Can manage users, students, teachers, parents in their organization
- Cannot modify Super Admin accounts
- Cannot access data from other organizations

### Head of Study
- Academic oversight within their organization
- Can view all students, teachers, and classes
- Can update enrollments and class schedules
- Can approve timesheets
- Can send evaluations

### Teacher
- Limited to their own classes and students
- Can create and grade assignments
- Can mark attendance for their classes
- Can create and send monthly evaluations
- Can update their own timesheet
- Can update their own profile

### Student
- Can view their own enrollments and classes
- Can view their assignments and grades
- Can submit assignments
- Can view their attendance and evaluations
- Can view messages and notifications
- Can update their own profile

### Parent
- Can view their children's information
- Can view class schedules and attendance
- Can view assignments and grades
- Can view evaluations
- Can communicate with teachers
- Can view notifications

## Using Policies in Controllers

### Authorization Checks

```php
// Authorize a single model action
this->authorize('update', $student);

// Authorize without a model
this->authorize('create', Student::class);

// Using the gate
if (Gate::allows('update', $student)) {
    // Perform action
}

// Custom policy methods
this->authorize('markAttendance', $classSession);
```

### In Blade Templates

```blade
@can('view', $student)
    <!-- Show student details -->
@endcan

@can('update', $student)
    <!-- Show edit button -->
@endcan

@cannot('delete', $student)
    <!-- Show delete disabled -->
@endcannot
```

## Policy Registration

Policies are automatically discovered by Laravel if they follow the naming convention:
- Model: `App\Models\Student`
- Policy: `App\Policies\StudentPolicy`

Register in `AuthServiceProvider.php` if needed:

```php
protected $policies = [
    Student::class => StudentPolicy::class,
    // ...
];
```

## Permission Strings

Policies check for specific permissions. Common permission strings:

- `view_all_{model}s` - View all models globally
- `view_organization_{model}s` - View models in user's organization
- `create_{model}s` - Create new models
- `update_{model}s` - Update models
- `delete_{model}s` - Delete models
- `restore_{model}s` - Restore soft-deleted models
- `force_delete_{model}s` - Permanently delete models

## Best Practices

1. **Always check organization**: Admins should only access data in their organization
2. **Ownership checks**: Teachers/Students can usually access their own data
3. **Progressive disclosure**: Parents can see their children, teachers see their students
4. **Soft deletes**: Implement restore and forceDelete methods
5. **Custom actions**: Create custom policy methods for domain-specific actions
6. **Performance**: Use eager loading with policies to avoid N+1 queries

## Testing Policies

```php
public function test_student_can_view_own_profile()
{
    $student = Student::factory()->create();
    $user = User::factory()->create(['student_id' => $student->id])->assignRole('Student');
    
    $this->assertTrue($user->can('view', $student));
}

public function test_parent_can_view_child_profile()
{
    $student = Student::factory()->create();
    $parent = User::factory()->create()->assignRole('Parent');
    $parent->children()->attach($student);
    
    $this->assertTrue($parent->can('view', $student));
}
```

## Migration Guide

When adding new models:

1. Create corresponding policy file
2. Implement standard CRUD methods
3. Add role-based checks appropriate to your domain
4. Create permissions in database seeder
5. Add comprehensive tests
6. Document in this README
