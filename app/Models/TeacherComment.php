<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TeacherComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teacher_comments';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'enrollment_id',
        'comment',
        'comment_type',
        'visible_to_parent',
    ];

    protected $casts = [
        'visible_to_parent' => 'boolean',
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
