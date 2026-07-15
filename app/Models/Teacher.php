<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_id',
        'qualification',
        'specialization',
        'years_of_experience',
        'date_of_joining',
        'employment_type',
        'hourly_rate',
        'bank_account',
        'bank_name',
        'bio',
        'certification',
        'is_active',
        'is_verified',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
        'hourly_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject')
            ->withPivot('is_primary');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function monthlyEvaluations(): HasMany
    {
        return $this->hasMany(MonthlyEvaluation::class);
    }

    public function behaviourReports(): HasMany
    {
        return $this->hasMany(BehaviourReport::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    public function teacherComments(): HasMany
    {
        return $this->hasMany(TeacherComment::class);
    }

    public function timesheets(): HasMany
    {
        return $this->hasMany(TeacherTimesheet::class);
    }

    public function learningResources(): HasMany
    {
        return $this->hasMany(LearningResource::class);
    }

    public function calendarEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
