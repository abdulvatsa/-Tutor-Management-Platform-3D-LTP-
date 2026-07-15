<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class LearningResource extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'learning_resources';

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'title',
        'description',
        'resource_type',
        'file_path',
        'external_url',
        'thumbnail',
        'duration_minutes',
        'view_count',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
