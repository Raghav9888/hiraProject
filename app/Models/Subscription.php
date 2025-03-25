<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'type', 'stripe_id', 'stripe_status', 'stripe_price', 'quantity', 'trial_ends_at', 'ends_at'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
