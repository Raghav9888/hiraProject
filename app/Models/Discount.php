<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'coupon_code',
        'coupon_description',
        'discount_type',
        'apply_all_services',
        'coupon_amount',
        'minimum_spend',
        'maximum_spend',
        'individual_use_only',
        'exclude_sale_items',
        'offerings',
        'exclude_services',
        'email_restrictions',
        'usage_limit_per_coupon',
        'usage_limit_to_x_items',
        'usage_limit_per_user',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'apply_all_services' => 'boolean',
        'individual_use_only' => 'boolean',
        'exclude_sale_items' => 'boolean',
        'offerings' => 'array',
        'exclude_services' => 'array',
        'email_restrictions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
