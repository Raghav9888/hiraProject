<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'offering_id',
        'specify',
        'date_and_time',
        'recurring_days',
        'event_duration',
        'sports',
        'scheduling_window',
        'scheduling_window_event_type',
        'email_template',
        'client_price',
        'tax_amount',
        'intake_form',
        'is_cancelled',
        'cancellation_time_slot',
        'is_confirmation',

    ];
    use HasFactory;

    protected $table = 'events';


    public function offering()
    {
        return $this->belongsTo(Offering::class);
    }

}
