<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Poll;

class PollSettings extends Model
{
    //
    protected $fillable = [
        'poll_id',
        'all_portfolios',
        'querystring',
        'hash_voter_names_numbers',
        'hash_voter_names_Alphabet',
        'show_teaser',
        'hide_profile_pictures',
        'anonymous_voting',
        'show_candidate_cgpa',
        'display_ballot_numbers',
        'allow_candidate_biographies',
        'show_live_results',
        'display_vote_counts',
        'send_result_slips',
        'show_percentage_results',
        'created_at',
        'updated_at',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
