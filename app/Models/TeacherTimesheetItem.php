<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherTimesheetItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'teacher_timesheet_id',
        'class_session_id',
        'date',
        'start_time',
        'end_time',
        'hours_worked',
        'rate',
        'amount',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the timesheet this item belongs to
     */
    public function timesheet(): BelongsTo
    {
        return $this->belongsTo(TeacherTimesheet::class, 'teacher_timesheet_id');
    }

    /**
     * Get the class session for this timesheet item
     */
    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }
}
