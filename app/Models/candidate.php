<?php

namespace App\Models;

use App\Models\Poll;
use App\Models\Portfolios;
use App\Models\Votes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class candidate extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'teaser',
        'team_name',
        'school_id',
        'role',
        'portfolio_id',
        'ghana_card_id',
        'biography',
        'image_path',
        'cgpa',
        'hall',
        'password',
        'ballot_number',
        'poll_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relationship: Poll that the candidate belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Relationship: Votes received by the candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(Votes::class);
    }

    /**
     * Calculate total votes for the candidate.
     *
     * @return int
     */
    public function totalVotes()
    {
        return $this->votes()->count();
    }

    /**
     * Relationship: Portfolio that the candidate belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolios::class, 'portfolio_id');
    }
}