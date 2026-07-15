<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'quiz_questions';

    protected $fillable = [
        'quiz_id',
        'question_type',
        'question_text',
        'options',
        'correct_answer',
        'points',
        'explanation',
        'sequence',
    ];

    protected $casts = [
        'options' => 'json',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
