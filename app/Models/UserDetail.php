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
        'IHelpWith',
        'HowIHelp',
        'specialities',
        'certifications',
        'endorsements',
        'timezone',
        'is_opening_hours',
        'is_notice',
        'is_google_analytics',
        'privacy_policy',
        'terms_condition',
        'cancellation_policy',
        'amenities',
        'slug',
        'store_availabilities'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->hasMany(PractitionerTag::class, 'id', 'tags');
    }

    public function  IHelpWith()
    {
        return $this->hasMany(IHelpWith::class, 'id', 'IHelpWith');
    }

    public function HowIHelp()
    {
        return $this->hasMany(HowIHelp::class, 'id', 'HowIHelp');
    }


}
