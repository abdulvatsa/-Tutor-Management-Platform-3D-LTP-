<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_users', 'view_organization_users']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        // Super Admin can view any user
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admin can view users in their organization
        if ($user->hasRole('Admin')) {
            return $user->organization_id === $model->organization_id;
        }

        // Users can view their own profile
        if ($user->id === $model->id) {
            return true;
        }

        return $user->hasPermission('view_organization_users');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_users', 'create_organization_users']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // Super Admin can update any user
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Users can update their own profile
        if ($user->id === $model->id && $user->hasPermission('update_own_profile')) {
            return true;
        }

        // Admins can update users in their organization (except Super Admins)
        if ($user->hasRole('Admin') && $user->organization_id === $model->organization_id) {
            return !$model->hasRole('Super Admin');
        }

        return $user->hasPermission('update_users');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // Super Admin cannot be deleted
        if ($model->hasRole('Super Admin')) {
            return false;
        }

        // Only Super Admin can delete users
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admins can delete users in their organization (except Super Admins)
        if ($user->hasRole('Admin') && $user->organization_id === $model->organization_id) {
            return !$model->hasRole('Super Admin');
        }

        return $user->hasPermission('delete_users');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('restore_users');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_users');
    }
}
