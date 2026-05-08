<?php

namespace App\Models;

use App\Models\Nominee;
use Illuminate\Database\Eloquent\Model;

class running_mates extends Model
{
    //jNml9mJbHC
    protected $fillable = [
        'nominee_id',
        'running_mates_full_name',
        'running_mates_reg_number',
        'running_mates_phone',
        'running_mates_hall',
        'running_mates_program',
        'running_mates_status',
        'running_mates_cgpa',
        'running_mates_photo_path'
        
    ];

    public function nominee()
    {
        return $this->belongsTo(Nominee::class);
    }
}
