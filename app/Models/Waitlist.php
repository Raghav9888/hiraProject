<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'business_name',
        'phone',
        'website',
        'current_practice',
        'heard_from',
        'referral_name',
        'other_source',
        'called_to_join',
        'practice_values',
        'excitement_about_hira',
        'call_availability',
        'newsletter',
        'uploads',
    ];

    protected $casts = [
        'heard_from' => 'array',
        'uploads' => 'array',
    ];
}

