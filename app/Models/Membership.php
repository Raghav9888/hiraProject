<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'membership';

    protected $fillable = [
        'user_id',
        'confirm_necessary_certifications_credentials',
        'acknowledge_the_hira_collective_practitioner_agreement',
        'understand_declaration_serves',
        'referral_program',
        'membership_name',
        'membership_type',
        'payment_status',
        'subscription_status',
        'cancellation_reason',
        'name',
        'preferred_name',
        'pronouns',
        'phone_number',
        'location',
        'website_social_media_link',
        'business_name',
        'years_of_experience',
        'license_certification_number',
        'blogs_workshops_events',
        'collaboration_interests',
        'birthday',
        'membership_start_date',
        'renewal_date',
        'cancellation_date',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
