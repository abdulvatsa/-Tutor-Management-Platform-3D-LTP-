<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_attendance', 'view_organization_attendance']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        // Super Admin and Admin can view all attendance in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $attendance->organization_id;
        }

        // Head of Study can view all attendance in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $attendance->organization_id) {
            return true;
        }

        // Teacher can view attendance for their class sessions
        if ($user->hasRole('Teacher')) {
            return $attendance->classSession->teacher_id === $user->teacher_id;
        }

        // Student can view their own attendance
        if ($user->hasRole('Student')) {
            return $attendance->enrollment->student_id === $user->student_id;
        }

        // Parent can view their child's attendance
        if ($user->hasRole('Parent')) {
            return $attendance->enrollment->student->parents()->where('user_id', $user->id)->exists();
        }

        return $user->hasPermission('view_attendance');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_attendance', 'create_organization_attendance']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        // Super Admin and Admin can update attendance in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $attendance->organization_id;
        }

        // Head of Study can update attendance in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $attendance->organization_id) {
            return true;
        }

        // Teacher can update attendance for their class sessions
        if ($user->hasRole('Teacher')) {
            return $attendance->classSession->teacher_id === $user->teacher_id;
        }

        return $user->hasPermission('update_attendance');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        // Only Super Admin and Admin can delete attendance
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $attendance->organization_id;
        }

        return $user->hasPermission('delete_attendance');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Attendance $attendance): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_attendance');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendance $attendance): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_attendance');
    }
}
