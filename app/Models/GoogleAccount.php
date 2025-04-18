<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'user_id',
        'access_token',
        'refresh_token',
        'expires_at',
    ];
}

