<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\votes;
use App\Models\Poll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index(){
       // Count unique voters per hall (each user only counted once per hall)
        $hallVoterCounts = User::where('role', 'voter')
        ->select('hall', DB::raw('COUNT(DISTINCT id) as voter_count'))
        ->whereIn('id', function($query) {
            $query->select('user_id')
                ->from('votes')
                ->where('votes_status', 'voted');
        })
        ->groupBy('hall')
        ->pluck('voter_count', 'hall');

        //Get CASFORD voters count specifically
        $casfordVoters = $hallVoterCounts['CASFORD'] ?? 0;
        $valcoVoters = $hallVoterCounts['VALCO'] ?? 0;
        $KNHVoters = $hallVoterCounts['KNHALL'] ?? 0;
        $adehyeVoters = $hallVoterCounts['ADEHYE'] ?? 0;
        $oguaaVoters = $hallVoterCounts['OGUAA'] ?? 0;
        $ATLVoters = $hallVoterCounts['ATL'] ?? 0;
        $SRCfordVoters = $hallVoterCounts['SRC'] ?? 0;
        $supernuionfordVoters = $hallVoterCounts['GUSSS'] ?? 0;
        $valcotrustVoters = $hallVoterCounts['VTRUST'] ?? 0;
        $universityVoters = $hallVoterCounts['UHALL'] ?? 0;
        $specialVotesCount = $hallVoterCounts['SPECIAL'] ?? 0;
        //Returns an associative array with the hall as the key and the total votes as the value
        //dd($casfordVoters);

        // $valcoVoters= votes::where('user_id','VALCO')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $KNHVoters= votes::where('user_id','KNHALL')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $adehyeVoters= votes::where('user_id','ADEHYE')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $oguaaVoters=votes::where('user_id','OGUAA')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $ATLVoters= votes::where('user_id','ADEHYE')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $SRCfordVoters= votes::where('user_id','SRC')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $supernuionfordVoters= votes::where('user_id','GUSSS')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $valcotrustVoters= votes::where('user_id','VTRUST')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
        // $universityVoters= votes::where('user_id','UHALL')->whereHas('user', function($query) {
        //     $query->where('role', 'voter');
        // })->distinct('user_id')->count('user_id');
       
        // $specialVotesCount = votes::join('users', 'votes.user_id', '=', 'users.id')
        // ->selectRaw('users.hall, COUNT(*) as total_votes')
        // ->groupBy('users.hall', 'SPECIAL')
        // ->get();
        //dd($specialVotesCount);

        $activePolls = Poll::where('status', 'active')->get();
        $polls = Poll::all();

    $pollData = [];

    foreach ($activePolls as $poll) {
        $pollData[] = [
            'title' => $poll->title,
            'start' => \Carbon\Carbon::parse($poll->start_time)->timestamp * 1000,
            'end' => \Carbon\Carbon::parse($poll->end_time)->timestamp * 1000,
            'duration' => \Carbon\Carbon::parse($poll->end_time)->diffInSeconds($poll->start_time),
        ];
    }

    return view('livewire.admin.dashboard', [
        'hallVoterCounts' => $hallVoterCounts,
        'casfordVoter' => $casfordVoters,
        'valcoVoter' => $valcoVoters,
        'KNHVoters' => $KNHVoters,
        'adehyeVoters' => $adehyeVoters,
        'oguaaVoters' => $oguaaVoters,
        'ATLVoters' => $ATLVoters,
        'SRCfordVoters' => $SRCfordVoters,
        'supernuionfordVoters' => $supernuionfordVoters,
        'valcotrustVoters' => $valcotrustVoters,
        'universityVoters' => $universityVoters,
        'pollData' => $pollData, // Added this to pass the poll data to the view
        //'organizedVotes' => $organizedVotes,
        'polls' => $polls,
        //'specialVotesCount' => $specialVotesCount,
    ]);

    }

   
}