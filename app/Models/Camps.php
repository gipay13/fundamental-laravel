<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Camps extends Model
{
    protected $fillable = [
        'bootcamps_name',
        'price',
    ];
}
