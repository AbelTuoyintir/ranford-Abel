<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class votes extends Model
{
    //
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'poll_id',
        'candidate_id',
        'user_id',
        'poll_type',
        'votes',
        'votes_status' // Assuming each vote is tied to a voter (optional)
    ];
    protected $casts = [
        'votes_status' => 'string'
    ];
    /**
     * Relationship: Poll that the vote belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    

    /**
     * Relationship: Candidate that received the vote.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
