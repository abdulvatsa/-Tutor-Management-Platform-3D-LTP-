<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class RescheduleRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reschedule_requests';

    protected $fillable = [
        'class_session_id',
        'requested_by',
        'requested_new_start',
        'requested_new_end',
        'reason',
        'status',
        'approved_at',
        'approved_by',
        'approval_notes',
    ];

    protected $casts = [
        'requested_new_start' => 'datetime',
        'requested_new_end' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function classSession(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class);
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
