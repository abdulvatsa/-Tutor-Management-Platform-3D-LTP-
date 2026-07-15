<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherTimesheet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'teacher_id',
        'month',
        'year',
        'total_hours',
        'total_amount',
        'currency',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the organization this timesheet belongs to
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the teacher for this timesheet
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get all items in this timesheet
     */
    public function items(): HasMany
    {
        return $this->hasMany(TeacherTimesheetItem::class);
    }

    /**
     * Scope to filter submitted timesheets
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope to filter approved timesheets
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to filter draft timesheets
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
