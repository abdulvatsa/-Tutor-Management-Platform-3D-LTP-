<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'class_sessions';

    protected $fillable = [
        'enrollment_id',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'google_meet_link',
        'meeting_code',
        'status',
        'notes',
        'session_summary',
        'recording_url',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function googleMeetSession(): HasOne
    {
        return $this->hasOne(GoogleMeetSession::class);
    }

    public function rescheduleRequests(): HasMany
    {
        return $this->hasMany(RescheduleRequest::class);
    }

    public function timesheetItems(): HasMany
    {
        return $this->hasMany(TeacherTimesheetItem::class);
    }
}
