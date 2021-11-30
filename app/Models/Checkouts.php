<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkouts extends Model
{
    protected $fillable = [
        'users_id',
        'camps_id',
        'card_number',
        'expired',
        'cvc',
        'is_paid'
    ];

    /**
     * Get the camps that owns the Checkouts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function camps(): BelongsTo
    {
        return $this->belongsTo(Camps::class);
    }

    public function setExpiredAttribute($value)
    {
        $this->attributes['expired'] = date('Y-m-t', strtotime($value));
    }
}
