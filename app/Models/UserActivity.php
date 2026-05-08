<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    //
    protected $fillable = [
        'user_id',
        'school_id',
        'action',
        'session_id',
        'details',
        'created_at',
        'updated_at',
    ];
}
