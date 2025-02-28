<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordpressUser extends Model
{
    protected $connection = 'wordpress';
    protected $table = 'users';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = ['user_login', 'user_email', 'user_pass'];
}

