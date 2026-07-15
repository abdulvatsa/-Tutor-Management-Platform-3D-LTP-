<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subject;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_subjects', 'view_organization_subjects']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Subject $subject): bool
    {
        // Super Admin and Admin can view all subjects in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $subject->organization_id;
        }

        // All authenticated users can view subjects in their organization
        if ($user->organization_id === $subject->organization_id) {
            return true;
        }

        return $user->hasPermission('view_subjects');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_subjects', 'create_organization_subjects']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Subject $subject): bool
    {
        // Super Admin and Admin can update subjects in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $subject->organization_id;
        }

        // Head of Study can update subjects in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $subject->organization_id) {
            return true;
        }

        return $user->hasPermission('update_subjects');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Subject $subject): bool
    {
        // Only Super Admin and Admin can delete subjects
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $subject->organization_id;
        }

        return $user->hasPermission('delete_subjects');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Subject $subject): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_subjects');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Subject $subject): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_subjects');
    }
}
