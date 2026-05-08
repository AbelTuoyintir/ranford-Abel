<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateProfile extends Model
{
    //
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'confirmation_password',
        'contact',
        'bio',
        'image'
       
    ];
}
