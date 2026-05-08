<?php

namespace App\Models;

use App\Models\candidate_coalition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class election_coalition extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'start_time',
        'description',
        'end_time',
        'start_date',
        'status',
        'queryString',
        'poll_type',
        'total_voters',
        'votes_received',
        'vote_status'
    ];
    // In election_coalition model
    protected $casts = [
        'all_portfolios' => 'array',
        'skipped_votes_breakdown' => 'array'
    ];
    
    public function candidates()
    {
        return $this->hasMany(candidate_coalition::class);
    }
    public function votes()
    {
        return $this->hasMany(votes::class);
    }
    public function pollSettings()
    {
        return $this->hasOne(PollSettings::class);
    }
}
