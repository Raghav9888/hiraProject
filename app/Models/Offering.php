<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    use HasFactory;
    protected $table = 'offerings';
    
    protected $fillable = [
        'user_id',
        'name',
        'long_description',
        'short_description',
        'location',
        'help',
        'categories',
        'tags',
        'featured_image',
        'type',
        'booking_duration',
        'calendar_display_mode',
        'confirmation_requires',
        'cancel',
        'maximum_block',
        'period_booking_period',
        'booking_default_date_availability',
        'booking_check_availability_against',
        'restrict_days',
        'block_start',
        'range',
        'cost',
        'cost_range',
    ];

    protected $casts = [
        'location' => 'array',
        'booking_duration' => 'array',
        'maximum_block' => 'array',
        'restrict_days' => 'array',
        'range' => 'array',
        'cost' => 'array',
        'cost_range' => 'array',
        'confirmation_requires' => 'boolean',
        'cancel' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
