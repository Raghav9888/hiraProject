<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStripeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_user_id',
        'stripe_access_token',
        'stripe_refresh_token',
        'stripe_publishable_key',
    ];
}
