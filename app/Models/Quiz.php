<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'teacher_id',
        'subject_id',
        'title',
        'description',
        'instructions',
        'duration_minutes',
        'total_points',
        'passing_score',
        'show_results',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'show_results' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'instructions' => 'json',
    ];

    /**
     * Get the organization this quiz belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the teacher for this quiz
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the subject for this quiz
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all questions for this quiz
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }

    /**
     * Get all attempts for this quiz
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
