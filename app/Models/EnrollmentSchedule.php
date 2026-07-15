<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class EnrollmentSchedule extends Model
{
    use HasFactory;

    protected $table = 'enrollment_schedules';

    protected $fillable = [
        'enrollment_id',
        'day_of_week',
        'start_time',
        'end_time',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
