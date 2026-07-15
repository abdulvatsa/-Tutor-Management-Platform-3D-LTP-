<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Parent as ParentModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_parents', 'view_organization_parents']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, ParentModel $parent): bool
    {
        // Super Admin and Admin can view all parents in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $parent->organization_id;
        }

        // Parent can view their own profile
        if ($user->hasRole('Parent') && $user->parent_id === $parent->id) {
            return true;
        }

        // Teachers can view parents of their students
        if ($user->hasRole('Teacher')) {
            return $parent->students()
                ->whereHas('classes', fn ($q) => $q->where('teacher_id', $user->teacher_id))
                ->exists();
        }

        return $user->hasPermission('view_parents');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_parents', 'create_organization_parents']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, ParentModel $parent): bool
    {
        // Super Admin and Admin can update parents in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $parent->organization_id;
        }

        // Parents can update their own profile
        if ($user->hasRole('Parent') && $user->parent_id === $parent->id) {
            return $user->hasPermission('update_own_profile');
        }

        return $user->hasPermission('update_parents');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, ParentModel $parent): bool
    {
        // Only Super Admin and Admin can delete parents
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $parent->organization_id;
        }

        return $user->hasPermission('delete_parents');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, ParentModel $parent): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_parents');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, ParentModel $parent): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_parents');
    }
}
