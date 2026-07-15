<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonthlyEvaluation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'class_session_id',
        'student_id',
        'teacher_id',
        'month',
        'year',
        'academic_performance',
        'behaviour',
        'attendance_rate',
        'participation',
        'comments',
        'strengths',
        'areas_for_improvement',
        'status',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'academic_performance' => 'json',
        'strengths' => 'json',
        'areas_for_improvement' => 'json',
    ];

    /**
     * Get the organization this evaluation belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the class session for this evaluation
     */
    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }

    /**
     * Get the student for this evaluation
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the teacher for this evaluation
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Scope to filter sent evaluations
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope to filter draft evaluations
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
