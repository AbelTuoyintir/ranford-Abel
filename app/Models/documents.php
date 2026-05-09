<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Nominee;

class documents extends Model
{
    //
    protected $fillable = [
        'nominee_id',
        'type',
        'path',
        'status',
        'verified'
    ];

    public function nominee()
    {
        return $this->belongsTo(Nominee::class);
    }
}
