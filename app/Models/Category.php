<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description','status', 'created_by', 'updated_by', 'deleted_by','created_at','updated_at'];
}
