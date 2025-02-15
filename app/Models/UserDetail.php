<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $table = 'user_details';

    protected $fillable = [
        'user_id',
        'bio',
        'location',
        'tags',
        'images',
        'about_me',
        'help',
        'specialities',
        'certifications',
        'endorsements',
        'timezone',
        'is_opening_hours',
        'is_notice',
        'is_google_analytics',
        'privacy_policy',
        'terms_condition'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
