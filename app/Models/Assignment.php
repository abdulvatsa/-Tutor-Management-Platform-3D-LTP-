<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'teacher_id',
        'subject_id',
        'title',
        'description',
        'instructions',
        'due_date',
        'total_points',
        'type',
        'status',
        'file_url',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'instructions' => 'json',
    ];

    /**
     * Get the organization this assignment belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the teacher for this assignment
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject for this assignment
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all submissions for this assignment
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Get all classes assigned this assignment
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Enrollment::class, 'assignment_enrollments')
            ->withTimestamps();
    }

    /**
     * Scope to filter due assignments
     */
    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', now()->toDateString());
    }

    /**
     * Scope to filter overdue assignments
     */
    public function scopeOverdue($query)
    {
        return $query->whereDate('due_date', '<', now()->toDateString());
    }

    /**
     * Scope to filter by organization
     */
    public function scopeInOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }
}
