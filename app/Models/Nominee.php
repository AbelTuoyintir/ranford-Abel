<?php

namespace App\Models;

use App\Models\documents;
use App\Models\supporters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nominee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'reg_number',
        'position',
        'phone',
        'email',
        'hall',
        'program',
        'nominee_cgpa',
        'medical_clearance',
        'fee_paid',
        'declaration_signed',
        'photo_path',
        'role',
        'rejection_reason',
        'verified',
        'status'
    ];

    protected $casts = [
        'medical_clearance' => 'boolean',
        'fee_paid' => 'boolean',
        'declaration_signed' => 'boolean',
        'nominee_cgpa' => 'decimal:2', // Changed from 'cgpa' to 'nominee_cgpa'
        'verified' => 'boolean'
    ];

    public function supporters()
    {
        return $this->hasMany(supporters::class);
    }

    public function runningMate()
    {
        return $this->hasOne(running_mates::class);
    }

    public function documents()
    {
        return $this->hasMany(documents::class);
    }
}


