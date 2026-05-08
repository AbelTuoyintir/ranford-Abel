<?php

namespace App\Models;

use App\Models\election_coalition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class candidate_coalition extends Authenticatable
{
    //
    use HasFactory;
    protected $fillable = [
        'election_coalition_id',
        'name',
        'ballot_number',
        'ghana_card_id',
        'biography',
        'team_name',
        'portfolio',
        'image_path',
        'role',
        'password',
        'school_id',
        'votes',
        'votes_status',
        
    ];
    public function ArchievePolls()
    {
        return $this->belongsTo(election_coalition::class);
    }
    public function votes()
    {
        return $this->hasMany(Votes::class);
    }
    public function totalVotes()
    {
        return $this->votes()->count();
    }
    public function portfolio()
    {
        return $this->belongsTo(Portfolios::class, 'portfolio_id');
    }
}
