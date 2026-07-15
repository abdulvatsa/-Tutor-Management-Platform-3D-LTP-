<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'enrollment_id',
        'teacher_id',
        'subject_id',
        'title',
        'description',
        'scheduled_date',
        'start_time',
        'end_time',
        'duration_minutes',
        'status',
        'location',
        'meeting_url',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the organization this class session belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the enrollment for this class session
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the teacher for this class session
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject for this class session
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all attendance records for this class session
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all evaluations for this class session
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(MonthlyEvaluation::class);
    }

    /**
     * Scope to filter upcoming sessions
     */
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_date', '>=', now())->orderBy('scheduled_date');
    }

    /**
     * Scope to filter completed sessions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope to filter by organization
     */
    public function scopeInOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }
}
