<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_students', 'view_organization_students']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Student $student): bool
    {
        // Super Admin and Admin can view all students in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $student->organization_id;
        }

        // Teacher can view students they teach
        if ($user->hasRole('Teacher')) {
            return $student->classes()
                ->whereHas('teacher', fn ($q) => $q->where('user_id', $user->id))
                ->exists();
        }

        // Student can view their own profile
        if ($user->hasRole('Student') && $user->student_id === $student->id) {
            return true;
        }

        // Parent can view their children
        if ($user->hasRole('Parent')) {
            return $student->parents()->where('user_id', $user->id)->exists();
        }

        return $user->hasPermission('view_students');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_students', 'create_organization_students']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Student $student): bool
    {
        // Super Admin and Admin can update students in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $student->organization_id;
        }

        // Students can update their own profile
        if ($user->hasRole('Student') && $user->student_id === $student->id) {
            return $user->hasPermission('update_own_profile');
        }

        return $user->hasPermission('update_students');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Student $student): bool
    {
        // Only Super Admin and Admin can delete students
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $student->organization_id;
        }

        return $user->hasPermission('delete_students');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Student $student): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_students');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Student $student): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_students');
    }
}
