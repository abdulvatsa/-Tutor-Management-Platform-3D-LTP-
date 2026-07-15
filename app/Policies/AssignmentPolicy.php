<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Assignment;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_assignments', 'view_organization_assignments']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        // Super Admin and Admin can view all assignments in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $assignment->organization_id;
        }

        // Head of Study can view all assignments in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $assignment->organization_id) {
            return true;
        }

        // Teacher can view their own assignments
        if ($user->hasRole('Teacher') && $assignment->teacher_id === $user->teacher_id) {
            return true;
        }

        // Student can view assignments assigned to their class
        if ($user->hasRole('Student')) {
            return $assignment->classes()->where('student_id', $user->student_id)->exists();
        }

        // Parent can view assignments for their child
        if ($user->hasRole('Parent')) {
            return $assignment->classes()
                ->whereHas('enrollment', fn ($q) => $q->where('student_id', $user->parent_students->pluck('id')->toArray()))
                ->exists();
        }

        return $user->hasPermission('view_assignments');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_assignments', 'create_organization_assignments']) || $user->hasRole('Teacher');
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        // Super Admin and Admin can update assignments in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $assignment->organization_id;
        }

        // Teacher can update their own assignments (if not yet graded)
        if ($user->hasRole('Teacher') && $assignment->teacher_id === $user->teacher_id) {
            return $assignment->submissions()->where('status', 'graded')->count() === 0;
        }

        return $user->hasPermission('update_assignments');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        // Only Super Admin and Admin can delete assignments
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $assignment->organization_id;
        }

        // Teacher can delete their own assignments (if no submissions)
        if ($user->hasRole('Teacher') && $assignment->teacher_id === $user->teacher_id) {
            return $assignment->submissions()->count() === 0;
        }

        return $user->hasPermission('delete_assignments');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_assignments');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_assignments');
    }

    /**
     * Determine if the user can grade submissions.
     */
    public function gradeSubmission(User $user, Assignment $assignment): bool
    {
        // Teacher can grade submissions for their assignments
        if ($user->hasRole('Teacher') && $assignment->teacher_id === $user->teacher_id) {
            return true;
        }

        // Admin can grade any submission
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        return $user->hasPermission('grade_submissions');
    }
}
