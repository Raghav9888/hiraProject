<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'transaction_id',
        'response',
        'status',
    ];

    /**
     * Get the order that owns the payment.
     */
    public function order()
    {
        return $this->belongsTo(Booking::class);
    }
}
