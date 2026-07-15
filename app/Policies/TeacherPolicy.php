<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_teachers', 'view_organization_teachers']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Teacher $teacher): bool
    {
        // Super Admin, Admin, and Head of Study can view all teachers in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin', 'Head of Study'])) {
            return $user->organization_id === $teacher->organization_id;
        }

        // Teacher can view their own profile
        if ($user->hasRole('Teacher') && $user->teacher_id === $teacher->id) {
            return true;
        }

        return $user->hasPermission('view_teachers');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_teachers', 'create_organization_teachers']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Teacher $teacher): bool
    {
        // Super Admin and Admin can update teachers in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $teacher->organization_id;
        }

        // Head of Study can update teachers in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $teacher->organization_id) {
            return true;
        }

        // Teachers can update their own profile
        if ($user->hasRole('Teacher') && $user->teacher_id === $teacher->id) {
            return $user->hasPermission('update_own_profile');
        }

        return $user->hasPermission('update_teachers');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Teacher $teacher): bool
    {
        // Only Super Admin and Admin can delete teachers
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $teacher->organization_id;
        }

        return $user->hasPermission('delete_teachers');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Teacher $teacher): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_teachers');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Teacher $teacher): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_teachers');
    }
}
