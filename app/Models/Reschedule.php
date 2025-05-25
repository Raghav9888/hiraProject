<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Reschedule extends Model {
    protected $fillable = ['booking_id', 'refunded_amount'];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
