<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';

    protected $fillable = [
        'offering_id',
        'user_id',
        'event_id',
        'currency',
        'currency_symbol',
        'total_amount',
        'status',
        'booking_date',
        'time_slot',
        'user_timezone',
        'price',
        'is_confirmed',
        'first_name',
        'last_name',
        'billing_company',
        'billing_address',
        'billing_address2',
        'billing_country',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_phone',
        'billing_email',
        'notes',
        'shipping_name',
        'shipping_address',
        'shipping_country',
        'shipping_city',
        'shipping_postcode',
        'shipping_phone',
        'shipping_email',
        'tax_amount'
    ];

    /**
     * Get the offering associated with the booking.
     */
    public function offering()
    {
        return $this->belongsTo(Offering::class);
    }

    /**
     * Get the user who made the booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
