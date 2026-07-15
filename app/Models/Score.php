<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'subject_id',
        'enrollment_id',
        'assessment_type',
        'assessment_id',
        'points_earned',
        'total_points',
        'percentage',
        'grade',
        'recorded_date',
    ];

    protected $casts = [
        'recorded_date' => 'date',
    ];

    /**
     * Get the student for this score
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the subject for this score
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the enrollment for this score
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
