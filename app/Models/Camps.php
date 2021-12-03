<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Camps extends Model
{
    protected $fillable = [
        'bootcamps_name',
        'price',
    ];

    public function getIsRegisteredOnCampAttribute()
    {
        if (!Auth::check()) {
            //jika tidak ada user yg login makan function tidak akan dijalankan
            return false;
        }

        //melakukan cek apakah di db ada camp dengan user dimaksud
        return Checkouts::whereCampsId($this->id)->whereUsersId(Auth::id())->exists();
    }
}
