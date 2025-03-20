<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;

    protected $fillable = ['id','name','created_by', 'updated_by', 'deleted_by','created_at','updated_at','status'];
}
