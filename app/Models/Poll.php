<?php

namespace App\Models;
use App\Models\PollSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class poll extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'start_time',
        'description',
        'end_time',
        'start_date',
        'status',
        'image',
        'poll_type',
    ];


    public function candidates()
    {
        return $this->hasMany(candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(votes::class);
    }

    public function totalVotes()
    {
        return $this->votes()->count();
    }

    public function pollSettings()
    {
        return $this->hasOne(PollSettings::class);
    }
 
}

