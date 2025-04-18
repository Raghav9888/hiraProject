<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PractitionerTag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'created_by', 'updated_by'];

    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'tags', 'id');
    }
}
