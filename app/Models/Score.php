<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'scores';

    protected $fillable = [
        'student_id',
        'enrollment_id',
        'teacher_id',
        'score_type',
        'title',
        'score_obtained',
        'max_score',
        'percentage',
        'grade',
        'remarks',
        'score_date',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'score_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
