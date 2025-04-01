<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowIHelp extends Model
{
    use HasFactory;
    protected $table = 'how_i_help';

    protected $fillable = ['name', 'slug', 'description', 'created_by', 'updated_by'];

    public function userDetail()
    {
        return $this->belongsTo(UserDetail::class, 'HowIHelp', 'id');
    }
}
