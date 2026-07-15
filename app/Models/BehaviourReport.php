<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BehaviourReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'student_id',
        'teacher_id',
        'class_session_id',
        'date',
        'behaviour_type',
        'severity',
        'description',
        'action_taken',
        'parent_notified',
        'notified_at',
    ];

    protected $casts = [
        'date' => 'date',
        'parent_notified' => 'boolean',
        'notified_at' => 'datetime',
    ];

    /**
     * Get the organization this report belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the student for this report
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the teacher for this report
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the class session for this report
     */
    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }
}
