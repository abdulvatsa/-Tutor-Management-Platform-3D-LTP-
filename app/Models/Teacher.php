<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'hire_date',
        'employment_type',
        'qualifications',
        'profile_picture_url',
        'bio',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'is_active' => 'boolean',
        'qualifications' => 'json',
    ];

    protected $appends = ['full_name'];

    /**
     * Get the user associated with this teacher
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organization this teacher belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get all subjects taught by this teacher
     */
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects')
            ->withTimestamps();
    }

    /**
     * Get all class sessions for this teacher
     */
    public function classSessions(): HasMany
    {
        return $this->hasMany(ClassSession::class);
    }

    /**
     * Get all assignments created by this teacher
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get all timesheets for this teacher
     */
    public function timesheets(): HasMany
    {
        return $this->hasMany(TeacherTimesheet::class);
    }

    /**
     * Get all evaluations created by this teacher
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(MonthlyEvaluation::class);
    }

    /**
     * Get all calendar events for this teacher
     */
    public function calendarEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class);
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope to filter active teachers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by organization
     */
    public function scopeInOrganization($query, $organizationId)
    {
        return $query->where('organization_id', $organizationId);
    }

    /**
     * Scope to filter by subject
     */
    public function scopeTeachingSubject($query, $subjectId)
    {
        return $query->whereHas('subjects', fn ($q) => $q->where('subject_id', $subjectId));
    }
}
