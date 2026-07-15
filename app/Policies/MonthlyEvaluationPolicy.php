<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MonthlyEvaluation;
use Illuminate\Auth\Access\HandlesAuthorization;

class MonthlyEvaluationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['view_all_evaluations', 'view_organization_evaluations']);
    }

    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, MonthlyEvaluation $evaluation): bool
    {
        // Super Admin and Admin can view all evaluations in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $evaluation->organization_id;
        }

        // Head of Study can view all evaluations in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $evaluation->organization_id) {
            return true;
        }

        // Teacher can view evaluations for their students
        if ($user->hasRole('Teacher')) {
            return $evaluation->classSession->teacher_id === $user->teacher_id;
        }

        // Student can view their own evaluations
        if ($user->hasRole('Student')) {
            return $evaluation->classSession->enrollment->student_id === $user->student_id;
        }

        // Parent can view their child's evaluations
        if ($user->hasRole('Parent')) {
            return $evaluation->classSession->enrollment->student->parents()->where('user_id', $user->id)->exists();
        }

        return $user->hasPermission('view_evaluations');
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission(['create_evaluations', 'create_organization_evaluations']);
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, MonthlyEvaluation $evaluation): bool
    {
        // Super Admin and Admin can update evaluations in their organization
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $evaluation->organization_id;
        }

        // Head of Study can update evaluations in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $evaluation->organization_id) {
            return true;
        }

        // Teacher can update their own evaluations (if not sent)
        if ($user->hasRole('Teacher') && $evaluation->classSession->teacher_id === $user->teacher_id) {
            return $evaluation->status !== 'sent';
        }

        return $user->hasPermission('update_evaluations');
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, MonthlyEvaluation $evaluation): bool
    {
        // Only Super Admin and Admin can delete evaluations
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return $user->organization_id === $evaluation->organization_id;
        }

        return $user->hasPermission('delete_evaluations');
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, MonthlyEvaluation $evaluation): bool
    {
        return $user->hasAnyRole(['Super Admin', 'Admin']) || $user->hasPermission('restore_evaluations');
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, MonthlyEvaluation $evaluation): bool
    {
        return $user->hasRole('Super Admin') || $user->hasPermission('force_delete_evaluations');
    }

    /**
     * Determine if the user can send the evaluation to parents.
     */
    public function sendToParent(User $user, MonthlyEvaluation $evaluation): bool
    {
        // Super Admin and Admin can send any evaluation
        if ($user->hasAnyRole(['Super Admin', 'Admin'])) {
            return true;
        }

        // Head of Study can send evaluations in their organization
        if ($user->hasRole('Head of Study') && $user->organization_id === $evaluation->organization_id) {
            return true;
        }

        // Teacher can send their own evaluations (if not already sent)
        if ($user->hasRole('Teacher') && $evaluation->classSession->teacher_id === $user->teacher_id) {
            return $evaluation->status !== 'sent';
        }

        return $user->hasPermission('send_evaluations');
    }
}
