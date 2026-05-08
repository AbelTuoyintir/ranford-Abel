<?php

namespace App\Models;

use App\Models\Nominee;
use Illuminate\Database\Eloquent\Model;

class documents extends Model
{
    //
    protected $fillable = [
        'nominee_id',
        'type',
        'path',
        'verified'
    ];

    public function nominee()
    {
        return $this->belongsTo(Nominee::class);
    }
}
