<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IHelpWith extends Model
{
    use HasFactory;
    protected $table = 'i_help_with';
    protected $fillable = ['name', 'slug', 'description', 'created_by', 'updated_by'];

    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'IHelpWith', 'id');
    }
}
