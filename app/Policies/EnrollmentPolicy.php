<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrollmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_enrollments', 'view_organization_enrollments']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Enrollment $enrollment): bool
    {
        // Super Admin and Admin can view all enrollments in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $enrollment->organization_id;
        }

        // Head of Study can view enrollments in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $enrollment->organization_id) {
            return true;
        }

        // Teacher can view enrollments for their classes
        if ($user->hasRole('Teacher')) {
            return $enrollment->classes()
                ->where('teacher_id', $user->teacher_id)
                ->exists();
        }

        // Student can view their own enrollment
        if ($user->hasRole('Student') && $enrollment->student_id === $user->student_id) {
            return true;
        }

        // Parent can view their child's enrollment
        if ($user->hasRole('Parent')) {
            return $enrollment->student->parents()->where('user_id', $user->id)->exists();
        }

        return $user->hasPermission('view_enrollments');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_enrollments', 'create_organization_enrollments']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Enrollment $enrollment): bool
    {
        // Super Admin and Admin can update enrollments in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $enrollment->organization_id;
        }

        // Head of Study can update enrollments in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $enrollment->organization_id) {
            return true;
        }

        return $user->hasPermission('update_enrollments');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Enrollment $enrollment): bool
    {
        // Only Super Admin and Admin can delete enrollments
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $enrollment->organization_id;
        }

        // Head of Study can delete enrollments in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $enrollment->organization_id) {
            return true;
        }

        return $user->hasPermission('delete_enrollments');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Enrollment $enrollment): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin', 'Head of Study']) || $user->hasPermission('restore_enrollments');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Enrollment $enrollment): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_enrollments');
    }
}
