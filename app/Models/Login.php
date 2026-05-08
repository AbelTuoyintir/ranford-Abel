<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;

class Login extends Model
{
    //
    protected $fillable = [
        'school_id',
        'password',
    ];


    protected $casts = [
        'password' => 'hashed',
    ];
}
