<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class Ticket extends Authenticatable
{
    protected $fillable = [
        'Voucher',
        'name',
        'team',
        'Password',
        'password_encrypted',
        'school_id',
        'expire_at',
    ];

    /**
     * Decrypt the stored encrypted plaintext password for admin display.
     *
     * NOTE: This only works if the `tickets.password_encrypted` column exists
     * and rows have valid encrypted values encrypted using the same APP_KEY.
     */
    //relation with user
    public function user(){
        return $this->belongsTo(User::class, "school_id");
    }
}

