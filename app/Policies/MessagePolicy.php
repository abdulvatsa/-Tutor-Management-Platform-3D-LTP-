<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_messages');
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Message $message): bool
    {
        // Users can view messages they sent or received
        if ($message->sender_id === $user->id || $message->recipient_id === $user->id) {
            return true;
        }

        // Super Admin can view any message
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        // Admin can view messages in their organization
        if ($user->hasRole('Admin') && $user->organization_id === $message->organization_id) {
            return true;
        }

        return $user->hasPermission('view_all_messages');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('send_messages');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Message $message): bool
    {
        // Users can delete their own messages (if not read)
        if ($message->sender_id === $user->id && !$message->is_read) {
            return true;
        }

        // Super Admin can delete any message
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return $user->hasPermission('delete_messages');
    }
}
