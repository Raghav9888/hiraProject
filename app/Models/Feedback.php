<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'practitioner_id', 'offering_id', 'name', 'image', 'comment', 'rating','feedback_type'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    public function offering()
    {
        return $this->belongsTo(Offering::class, 'offering_id');
    }
}
