<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'testimonials';

    protected $fillable = [
        'name',
        'email',
        'designation',
        'testimonial',
        'image',
        'rating',
        'is_approved',
        'is_published',
        'display_order',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_published' => 'boolean',
    ];
}
