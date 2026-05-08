<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    //
    protected $fillable = [
        'address',
        'label',
        'active',
        'date_added',
        'last_active',
    ];
}
