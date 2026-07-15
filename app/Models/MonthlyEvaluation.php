<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class MonthlyEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'monthly_evaluations';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'enrollment_id',
        'evaluation_year',
        'evaluation_month',
        'academic_progress',
        'academic_progress_comments',
        'behaviour_rating',
        'behaviour_comments',
        'participation_rating',
        'participation_comments',
        'homework_completion',
        'homework_comments',
        'communication_rating',
        'communication_comments',
        'strengths',
        'areas_for_improvement',
        'goals_for_next_month',
        'teacher_recommendations',
        'completed_at',
        'sent_to_parent',
        'sent_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'sent_at' => 'datetime',
        'sent_to_parent' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
