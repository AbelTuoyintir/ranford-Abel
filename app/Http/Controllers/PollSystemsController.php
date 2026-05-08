<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\User;
use App\Models\PollSettings;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollSystemsController extends Controller
{
    //
    public function Settings (Request $request){
        
        $user = Auth::user();
        $validated = $request->validate([
            'poll_id' => 'required',
            'title' => 'required|string|max:255',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time',
            'start_date' => 'required',
            // 'poll_type' => 'required',
            'description' => 'nullable|string',
        ]);
       
        // Set default values for checkboxes
        $settings = [
            "hash_voter_names_numbers" => $request->has('hash_voter_names_numbers'),
            "hash_voter_names_Alphabet" => $request->has('hash_voter_names_Alphabet'),
            "hide_profile_pictures" => $request->has('hide_profile_pictures'),
            "anonymous_voting" => $request->has('anonymous_voting'),
            "show_candidate_cgpa" => $request->has('show_candidate_cgpa'),
            "show_teaser" => $request->has('show_teaser'),
            "display_ballot_numbers" => $request->has('display_ballot_numbers'),
            "allow_candidate_biographies" => $request->has('allow_candidate_biographies'),
            "show_live_results" => $request->has('show_live_results'),
            "display_vote_counts" => $request->has('display_vote_counts'),
            "show_percentage_results" => $request->has('show_percentage_results'),
            "send_result_slips" => $request->has('send_result_slips'),
        ];
        
        $poll = Poll::findOrFail($validated['poll_id']);

    // Update the poll with validated data
    
    
    $pollSettings=PollSettings::where('poll_id',$validated['poll_id']);
    if($request->query_general){
        $querystring = Poll::where('id', $validated['poll_id'])->value('poll_type');
    }
    elseif($request->query_department){
        $querystring=$request->query_department;
    }
    elseif($request->query_hall){
        $querystring=$request->query_hall;
    }else{
        //Handle special voting query when 'query_special' is provided
        if ($request->has('special_voting_groups') && is_array($request->special_voting_groups)) {
            // Grab the selected special voting groups
            $selectedGroups = $request->special_voting_groups;
            
            // Append "PERMANENT" to the selected groups
            $selectedGroups[] = 'PERMANENT'; // Add "PERMANENT" to the array
            
            // Convert the array to a space-separated string
            $querystring = implode(' ', $selectedGroups); 
        } else {
            // If no special voting groups are selected
            $querystring = 'No special voting groups selected';
        }
        
    }
    //dd($querystring);
    if($request->special_voting_groups||$request->query_hall || $request->query_department || $request->query_general){
        if($pollSettings){
            $poll->update($validated);
            $pollSettings->update([
                'querystring' => $querystring ,
            ]);
            $this->logUserActivity($user, 'Poll Settings',' Poll and Poll Settings updated  successfully.');
            return back()->with('success', 'Poll and Poll Settings updated  successfully.');
        }else{
            PollSettings::create([
                'poll_id' =>$validated['poll_id'] ,
                'querystring'=>$querystring,
                'all_portfolios'=>'',
                'hash_voter_names_numbers'=>$settings['hash_voter_names_numbers'],
                'hash_voter_names_Alphabet'=>$settings['hash_voter_names_Alphabet'],
                'show_teaser'=>$settings['show_teaser'],
                'hide_profile_pictures'=>$settings['hide_profile_pictures'],
                'anonymous_voting'=>$settings['anonymous_voting'],
                'all_portfolios'=>$settings['all_portfolios'],
                'show_candidate_cgpa'=>$settings['show_candidate_cgpa'],
                'display_ballot_numbers'=>$settings['display_ballot_numbers'],
                'allow_candidate_biographies'=>$settings['allow_candidate_biographies'],
                'show_live_results'=>$settings['show_live_results'],
                'display_vote_counts'=>$settings['display_vote_counts'],
                'show_percentage_results'=>$settings['show_percentage_results'],
                'send_result_slips'=>$settings['send_result_slips'],
    
    
            ]);
            $this->logUserActivity($user, 'Poll Settings',' Poll Settings  successfully');
    
            return back()->with('success', ' Poll Settings  successfully.');
        }
    }

    else{
        $querystring = Poll::where('id', $validated['poll_id'])->value('poll_type');
        if($pollSettings){
            $poll->update($validated);
            $pollSettings->update([
                'querystring' => $querystring ,
            ]);
            $this->logUserActivity($user, 'Poll Settings',' Poll and Poll Settings updated  successfully.');
            return back()->with('success', 'Poll and Poll Settings updated  successfully.');
        }else{
            PollSettings::create([
                'poll_id' =>$validated['poll_id'] ,
                'querystring'=>$querystring,
                'all_portfolios'=>'',
                'hash_voter_names_numbers'=>$settings['hash_voter_names_numbers'],
                'hash_voter_names_Alphabet'=>$settings['hash_voter_names_Alphabet'],
                'show_teaser'=>$settings['show_teaser'],
                'hide_profile_pictures'=>$settings['hide_profile_pictures'],
                'anonymous_voting'=>$settings['anonymous_voting'],
                'all_portfolios'=>$settings['all_portfolios'],
                'show_candidate_cgpa'=>$settings['show_candidate_cgpa'],
                'display_ballot_numbers'=>$settings['display_ballot_numbers'],
                'allow_candidate_biographies'=>$settings['allow_candidate_biographies'],
                'show_live_results'=>$settings['show_live_results'],
                'display_vote_counts'=>$settings['display_vote_counts'],
                'show_percentage_results'=>$settings['show_percentage_results'],
                'send_result_slips'=>$settings['send_result_slips'],
    
    
            ]);
            $this->logUserActivity($user, 'Poll Settings',' Poll Settings  successfully');
    
            return back()->with('success', ' Poll Settings  successfully.');
        }
    }
    
   


    }


    protected function logUserActivity(User $user, string $action, string $details)
{  
    UserActivity::create([
        'session_id' => session()->getId(),

        'user_id' => $user->id,
        'school_id' => $user->school_id,
        'action' => $action,
        'details' => $details,
        'ip_address' => request()->ip(), // Get the user's IP address
        'user_agent' => request()->userAgent(), // Get the user's browser user agent
    ]);
}
    
}
