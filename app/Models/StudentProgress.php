<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'subject_id',
        'enrollment_id',
        'month',
        'year',
        'overall_score',
        'learning_objectives',
        'progress_notes',
        'challenges',
        'recommendations',
    ];

    protected $casts = [
        'learning_objectives' => 'json',
        'challenges' => 'json',
        'recommendations' => 'json',
    ];

    /**
     * Get the student for this progress
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject for this progress
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the enrollment for this progress
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
