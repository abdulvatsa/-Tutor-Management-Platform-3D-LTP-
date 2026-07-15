<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'email_logs';

    protected $fillable = [
        'recipient_email',
        'subject',
        'body',
        'email_type',
        'mailable_type',
        'mailable_id',
        'status',
        'error_message',
    ];
}
