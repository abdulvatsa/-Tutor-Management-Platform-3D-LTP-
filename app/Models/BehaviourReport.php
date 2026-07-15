<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BehaviourReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'behaviour_reports';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'enrollment_id',
        'incident_type',
        'title',
        'description',
        'incident_date',
        'action_taken',
        'notes',
        'parent_notified',
        'notified_at',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'parent_notified' => 'boolean',
        'notified_at' => 'datetime',
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
