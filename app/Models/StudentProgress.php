<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class StudentProgress extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'student_progress';

    protected $fillable = [
        'student_id',
        'enrollment_id',
        'average_score',
        'assignment_completion_rate',
        'quiz_completion_rate',
        'attendance_percentage',
        'sessions_completed',
        'sessions_missed',
        'overall_assessment',
        'last_progress_update',
    ];

    protected $casts = [
        'average_score' => 'decimal:2',
        'attendance_percentage' => 'decimal:2',
        'last_progress_update' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
