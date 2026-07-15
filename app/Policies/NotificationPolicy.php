<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_notifications');
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Notification $notification): bool
    {
        // Users can view their own notifications
        if ($notification->user_id === $user->id) {
            return true;
        }

        // Super Admin can view any notification
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return $user->hasPermission('view_all_notifications');
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Notification $notification): bool
    {
        // Users can mark their own notifications as read
        if ($notification->user_id === $user->id) {
            return true;
        }

        return $user->hasPermission('update_notifications');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Notification $notification): bool
    {
        // Users can delete their own notifications
        if ($notification->user_id === $user->id) {
            return true;
        }

        // Super Admin can delete any notification
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return $user->hasPermission('delete_notifications');
    }
}
