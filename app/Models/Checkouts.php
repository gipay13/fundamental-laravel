<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkouts extends Model
{
    protected $fillable = [
        'users_id',
        'camps_id',
        'card_number',
        'expire',
        'cvc',
        'is_paid'
    ];
}
