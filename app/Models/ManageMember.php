<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageMember extends Model
{
    //
    protected $fillable = [
        'firstName',
        'lastName',
        'school_id',
        'programs',
        'phone' ,
        'image',
        'email',
        'team_name',
        'bio',
        'gender',
        'hall',
    ];
}
