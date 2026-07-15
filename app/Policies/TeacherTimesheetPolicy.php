<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TeacherTimesheet;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherTimesheetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_timesheets', 'view_organization_timesheets']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, TeacherTimesheet $timesheet): bool
    {
        // Super Admin and Admin can view all timesheets in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $timesheet->organization_id;
        }

        // Head of Study can view all timesheets in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $timesheet->organization_id) {
            return true;
        }

        // Teacher can view their own timesheet
        if ($user->hasRole('Teacher') && $timesheet->teacher_id === $user->teacher_id) {
            return true;
        }

        return $user->hasPermission('view_timesheets');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_timesheets', 'create_organization_timesheets']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, TeacherTimesheet $timesheet): bool
    {
        // Super Admin and Admin can update timesheets in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $timesheet->organization_id;
        }

        // Head of Study can update timesheets in their organization (if not approved)
        if ($user->hasRole('Head of Study') && $user->organization_id === $timesheet->organization_id) {
            return $timesheet->status !== 'approved';
        }

        // Teacher can update their own timesheet (if not submitted)
        if ($user->hasRole('Teacher') && $timesheet->teacher_id === $user->teacher_id) {
            return $timesheet->status !== 'submitted' && $timesheet->status !== 'approved';
        }

        return $user->hasPermission('update_timesheets');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, TeacherTimesheet $timesheet): bool
    {
        // Only Super Admin and Admin can delete timesheets
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $timesheet->organization_id;
        }

        return $user->hasPermission('delete_timesheets');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, TeacherTimesheet $timesheet): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_timesheets');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, TeacherTimesheet $timesheet): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_timesheets');
    }

    /**
     * Determine if the user can approve the timesheet.
     */
    public function approve(User $user, TeacherTimesheet $timesheet): bool
    {
        // Super Admin and Admin can approve timesheets
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $timesheet->organization_id;
        }

        // Head of Study can approve timesheets in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $timesheet->organization_id) {
            return $timesheet->status === 'submitted';
        }

        return $user->hasPermission('approve_timesheets');
    }
}
