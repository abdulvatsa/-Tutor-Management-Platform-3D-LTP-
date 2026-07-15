<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
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
        'enrollment_date',
        'academic_level_id',
        'profile_picture_url',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected $appends = ['full_name'];

    /**
     * Get the user associated with this student
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the organization this student belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the academic level for this student
     */
    public function academicLevel(): BelongsTo
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    /**
     * Get all enrollments for this student
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get all class sessions for this student (through enrollments)
     */
    public function classSessions(): BelongsToMany
    {
        return $this->belongsToMany(ClassSession::class, 'enrollments')
            ->withTimestamps();
    }

    /**
     * Get all attendance records for this student
     */
    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all assignment submissions for this student
     */
    public function assignmentSubmissions(): HasMany
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    /**
     * Get all quiz attempts for this student
     */
    public function quizAttempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get all scores for this student
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get all evaluations for this student
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(MonthlyEvaluation::class);
    }

    /**
     * Get all behaviour reports for this student
     */
    public function behaviourReports(): HasMany
    {
        return $this->hasMany(BehaviourReport::class);
    }

    /**
     * Get progress tracking for this student
     */
    public function progress(): HasMany
    {
        return $this->hasMany(StudentProgress::class);
    }

    /**
     * Get parents of this student
     */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'student_parents', 'student_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope to filter active students
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
     * Scope to filter by academic level
     */
    public function scopeByAcademicLevel($query, $academicLevelId)
    {
        return $query->where('academic_level_id', $academicLevelId);
    }
}
