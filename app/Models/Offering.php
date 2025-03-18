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
        'offering_type',
        'booking_duration',
        'from_date',
        'to_date',
        'availability',
        'availability_type',
        'client_price',
        'tax_amount',
        'scheduling_window',
        'scheduling_window_offering_type',
        'buffer_time',
        'email_template',
        'intake_form',
        'is_cancelled',
        'cancellation_time_slot',
        'is_confirmation',
    ];

    protected $casts = [
        'is_cancelled' => 'boolean',
        'is_confirmation' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function event()
    {
        return $this->hasOne(Event::class, 'offering_id', 'id');
    }

}
