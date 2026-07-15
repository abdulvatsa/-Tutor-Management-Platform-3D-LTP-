<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassSession;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassSessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_class_sessions', 'view_organization_class_sessions']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, ClassSession $session): bool
    {
        // Super Admin and Admin can view all class sessions in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $session->organization_id;
        }

        // Head of Study can view all class sessions in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $session->organization_id) {
            return true;
        }

        // Teacher can view their own class sessions
        if ($user->hasRole('Teacher') && $session->teacher_id === $user->teacher_id) {
            return true;
        }

        // Student can view their class sessions
        if ($user->hasRole('Student')) {
            return $session->enrollment->student_id === $user->student_id;
        }

        // Parent can view their child's class sessions
        if ($user->hasRole('Parent')) {
            return $session->enrollment->student->parents()->where('user_id', $user->id)->exists();
        }

        return $user->hasPermission('view_class_sessions');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_class_sessions', 'create_organization_class_sessions']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, ClassSession $session): bool
    {
        // Super Admin and Admin can update class sessions in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $session->organization_id;
        }

        // Head of Study can update class sessions in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $session->organization_id) {
            return true;
        }

        // Teacher can update their own class sessions (if not started)
        if ($user->hasRole('Teacher') && $session->teacher_id === $user->teacher_id) {
            return $session->status !== 'started';
        }

        return $user->hasPermission('update_class_sessions');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, ClassSession $session): bool
    {
        // Only Super Admin and Admin can delete class sessions
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $session->organization_id;
        }

        // Head of Study can delete class sessions in their organization (if not started)
        if ($user->hasRole('Head of Study') && $user->organization_id === $session->organization_id) {
            return $session->status !== 'started';
        }

        return $user->hasPermission('delete_class_sessions');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, ClassSession $session): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_class_sessions');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClassSession $session): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_class_sessions');
    }

    /**
     * Determine if the user can mark attendance.
     */
    public function markAttendance(User $user, ClassSession $session): bool
    {
        // Teacher can mark attendance for their own sessions
        if ($user->hasRole('Teacher') && $session->teacher_id === $user->teacher_id) {
            return $session->status === 'started' || $session->status === 'completed';
        }

        // Admin can mark attendance
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->hasPermission('mark_attendance');
    }
}
