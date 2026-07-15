<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GoogleMeetSession extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'google_meet_sessions';

    protected $fillable = [
        'class_session_id',
        'meeting_code',
        'meeting_url',
        'meeting_id',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'participant_count',
        'recording_url',
        'is_recorded',
        'status',
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'is_recorded' => 'boolean',
    ];

    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }
}
