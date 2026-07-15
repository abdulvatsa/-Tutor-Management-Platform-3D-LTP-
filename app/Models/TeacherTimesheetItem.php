<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TeacherTimesheetItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teacher_timesheet_items';

    protected $fillable = [
        'teacher_timesheet_id',
        'class_session_id',
        'enrollment_id',
        'session_date',
        'start_time',
        'end_time',
        'hours_worked',
        'hourly_rate',
        'amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'session_date' => 'date',
        'hourly_rate' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function timesheet(): BelongsTo
    {
        return $this->belongsTo(TeacherTimesheet::class, 'teacher_timesheet_id');
    }

    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
