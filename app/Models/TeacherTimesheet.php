<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TeacherTimesheet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'teacher_timesheets';

    protected $fillable = [
        'teacher_id',
        'timesheet_year',
        'timesheet_month',
        'total_hours',
        'total_amount',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'approval_notes',
        'paid_at',
        'payment_reference',
    ];

    protected $casts = [
        'total_hours' => 'integer',
        'total_amount' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TeacherTimesheetItem::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
