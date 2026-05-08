<?php

namespace App\Models;

use App\Models\Nominee;
use Illuminate\Database\Eloquent\Model;

class supporters extends Model
{
    //
    protected $fillable = [
        'nominee_id',
        'name',
        'reg_number',
        'hall',
        'department',
        'program',
        'phone',
        'date',
        'email',
        'confirmation_token',
        'id_copy_path',
        'verified'
    ];

    protected $casts = [
        'verified' => 'boolean',
        'date' => 'date'
    ];
    public function nominee()
    {
        return $this->belongsTo(Nominee::class);
    }
}
