<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\User;
use App\Models\Votes;
use App\Models\Candidate;
use App\Models\PollSettings;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\election_coalition;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StrongroomController extends Controller
{
    public function index()
    {
        // Fetch all candidates
        
        $totalVoters = User::where('hall', auth()->user()->hall)->where('role', 'voter')->count();
        $voters = user::where('action', 'voted')->count();
        $nonVoters = user::where('action', 'not voted')->count();
        // $skippedVoters = vote::where('action', 'skipped')->count();
        // Count candidates for the authenticated user's hall
        $totalCandidateHall = Candidate::where('hall', auth()->user()->hall)->count();

        // Count candidates from the SRC poll (assuming poll_id or poll_type identifies SRC poll)
        // Get all poll IDs where poll_type is 'UCC GENERAL VOTING'
        $srcPollIds = Poll::where('poll_type', 'UCC GENERAL VOTING')->pluck('id');
        // Count candidates whose poll_id is in the above poll IDs
        $totalCandidateSRC = Candidate::whereIn('poll_id', $srcPollIds)->count();

        // Combine both counts if you want the total, or pass them separately as needed
        $totalCandidate = $totalCandidateHall + $totalCandidateSRC;
        $hallCandidates = Candidate::where('hall', auth()->user()->hall)->get();
        $CandidateSRC = Candidate::whereIn('poll_id', $srcPollIds)->get();
        $candidates = $hallCandidates->merge($CandidateSRC);
        
        // Get the authenticated user's hall (if logged in)
        $hall = auth()->check() ? auth()->user()->hall : null;
        
        $activePolls = poll::where('status', 'active')->get();
        $pollData = [];
        $polls = Poll::get();
        $studentCandidates = Candidate::where('poll_id', 'UCC GENERAL VOTING')->get();
    
    foreach ($activePolls as $poll) {
        $pollData[] = [
            'title' => $poll->title,
            'start' => \Carbon\Carbon::parse($poll->start_time)->timestamp * 1000,
            'end' => \Carbon\Carbon::parse($poll->end_time)->timestamp * 1000,
            'duration' => \Carbon\Carbon::parse($poll->end_time)->diffInSeconds($poll->start_time),
        ];
    } // Close the foreach loop first

    return view('livewire.admin.strongrooms', [
        'candidates' => $candidates,
        'hall' => $hall,
        'totalVoters' => $totalVoters,
        'pollData' => $pollData,
        'polls' => $polls,
        'voters' => $voters,
        'totalCandidate' => $totalCandidate,
    ]);
    }

    public function superStrongRoom(){
        $candidates = Candidate::with('portfolio')->get();
        $totalVoters= User::where('type', 'student')->where('role', 'voter')->count();
        $skippedVoters = Votes::where('votes_status', 'skipped')->count();
        // $totalVotes = Votes::count();
        $totalVotes= User::where('action', 'voted')->count();

        //dd($totalVoters);
        $srcPollIds = Poll::where('poll_type', 'UCC GENERAL VOTING')->orWhere('poll_type', 'DEPARTMENT')->pluck('id');
        // Count candidates whose poll_id is in the above poll IDs
        $totalCandidate = Candidate::whereIn('poll_id', $srcPollIds)->count();
        // dd($totalCandidate);
        $totalvoters = user::where('role', 'voter')->count();
        $poll_special = $candidates->isNotEmpty() ? Poll::where('id', $candidates->first()->poll_id)->first() : null;
         
        $poll = Poll::where('poll_type', 'UCC GENERAL VOTING')->orWhere('poll_type', 'DEPARTMENT')->with('candidates')->get();
        //dd($poll, $candidates, $totalvoters, $totalCandidate, $poll_special);

        return view('livewire.admin.superStrongRoom', [
            'candidates' => $candidates,
            'totalvoters' => $totalvoters,
            'totalCandidate' => $totalCandidate,
            'poll'=>$poll,
            'totalVoters' => $totalVoters,
            'poll_special'=>$poll_special,
            'skippedVoters' => $skippedVoters,
            'totalVotes' => $totalVotes,
        ]);
    }

    public function super_StrongRoom(){
        $candidates = candidate::where('poll_id', 'SPECIAL VOTING')->get();
        $totalvoters = user::where('role', 'voter')->count();
        $poll_special = $candidates->isNotEmpty() ? Poll::where('poll_id', $candidates->first()->poll_id)->where('poll_type', 'SPECIAL VOTING')->first() : null;
        $totalCandidate = candidate::where('poll_id', 'SPECIAL VOTING')->cout();

        // $poll_special = Poll::get();
        //dd($poll_special);

        $poll = Poll::where('poll_type', 'SPECIAL VOTING')->with('candidates')->get();

        // dd($poll);

        return view('livewire.admin.super-strongRoom', [
            'candidates' => $candidates,
            'totalvoters' => $totalvoters,
            'totalCandidate' => $totalCandidate,
            'poll'=>$poll,
        ]);
    }

    public function LoginPublicRoomPage()
    {
        return view('livewire.public-room-login');
    }

    public function camp()
{
    $candidate = Auth::guard('candidates')->user();
    
    // Check if a candidate is authenticated
    if (!$candidate) {
        return redirect()->route('login')->with('error', 'You need to log in to access this page.');
    }

    // Total votes for the candidate
    $totalVotes = votes::where('candidate_id', $candidate->id)->count();

    // Total voters in the system
    $totalvoters = user::where('role', 'voter')->count();

    // Total votes in the election
    $totalVotesElection = votes::count();

    // Total candidates in the same poll
    $totalcandidate = candidate::where('poll_id', $candidate->poll_id)->get();

    // Voter turnout percentage
    $voterTurnout = number_format(($totalVotes / $totalvoters) * 100, 2);

    // Votes received by the candidate grouped by hall
    $candidateVotesByHall = votes::where('candidate_id', $candidate->id)
                                 ->join('users', 'votes.user_id', '=', 'users.id')
                                 ->selectRaw('users.hall, COUNT(*) as total_votes')
                                 ->groupBy('users.hall')
                                 ->get()
                                 ->pluck('total_votes', 'hall')
                                 ->toArray();

    // Total votes in each hall (for all candidates)
    $totalVotesByHall = votes::join('users', 'votes.user_id', '=', 'users.id')
                             ->selectRaw('users.hall, COUNT(*) as total_votes')
                             ->groupBy('users.hall')
                             ->get()
                             ->pluck('total_votes', 'hall')
                             ->toArray();

    // Total number of people (voters) in each hall
    $totalPeopleByHall = user::where('role', 'voter')
                             ->selectRaw('hall, COUNT(*) as total_people')
                             ->groupBy('hall')
                             ->get()
                             ->pluck('total_people', 'hall')
                             ->toArray();

    // Predefined list of halls
    $allHalls = ['CASFORD', 'VALCO', 'KNHALL', 'OGUAA', 'ADEHYE', 'ATLANTIC', 'SRC', 'GUSSS', 'VTRUST', 'UHALL'];

    // Calculate votes and percentages for each hall
    $hallVotesData = [];
    foreach ($allHalls as $hall) {
        $candidateVotes = $candidateVotesByHall[$hall] ?? 0; // Votes the candidate received in this hall
        $totalHallVotes = $totalVotesByHall[$hall] ?? 0; // Total votes in this hall
        $totalPeople = $totalPeopleByHall[$hall] ?? 0; // Total number of people (voters) in this hall

        // Calculate the percentage of votes the candidate received in this hall
        $percentage = $totalHallVotes > 0 ? number_format(($candidateVotes / $totalPeople) * 100, 2) : 0;

        $hallVotesData[$hall] = [
            'total_people' => $totalPeople, // Total number of people in the hall
            'candidate_votes' => $candidateVotes, // Votes the candidate received in this hall
            'total_votes_in_hall' => $totalHallVotes, // Total votes in this hall
            'percentage' => $percentage, // Percentage of votes the candidate received
        ];
    }

    $activePolls = election_coalition::where('status', 'complete')->get();
    $pollData = [];

    foreach ($activePolls as $poll) {
        $pollData[] = [
            'title' => $poll->title,
            'start' => \Carbon\Carbon::parse($poll->start_time)->timestamp * 1000,
            'end' => \Carbon\Carbon::parse($poll->end_time)->timestamp * 1000,
            'duration' => \Carbon\Carbon::parse($poll->end_time)->diffInSeconds($poll->start_time),
        ];
    }

    // Pass the candidate's details to the view
    return view('livewire.candidates.camp', [
        'candidate' => $candidate,
        'totalVotes' => $totalVotes,
        'totalvoters' => $totalvoters,
        'pollData' => $pollData,
        'totalVotesElection' => $totalVotesElection,
        'totalcandidate' => $totalcandidate,
        'voterTurnout' => $voterTurnout,
        'hallVotesData' => $hallVotesData, // Pass the hall votes data to the view
    ]);
}

    public function ShowVoterResults(Request $request){
         // Fetch active polls with status 'complete' and eager load candidates
    $activePolls = election_coalition::where('status', 'complete')
    ->with('candidates') // Ensure the relationship is defined in the model
    ->get();

        // Group polls by poll_type
        $groupedPolls = $activePolls->groupBy('poll_type');

        // Group candidates by their portfolio for each poll
        foreach ($groupedPolls as $pollType => $polls) {
            foreach ($polls as $poll) {
                $poll->candidates = $poll->candidates->groupBy('portfolio');
            }
        }

    return view('livewire.admin.public-view', [
        'GroupedPollData' => $groupedPolls // Pass grouped polls to the view
    ]);
    }

    public function LoginPublicRoom(Request $request)
    {
        // Validate the request inputs
        $fields = $request->validate([
            'school_id' => ['required'],
            'password' => ['required'],
        ]);

        // Retrieve user by school_id
        $user = User::where('school_id', $fields['school_id'])->first();
        if(!$user){
           
            return back()->with('error', 'User  is not in our records or wrong credentials .');
        }
        // Check if user exists and the password is correct
        if ($user && Hash::check($fields['password'], $user->password)) {
            // Log the user in
            Auth::login($user);

            if ($user->role === 'verification_officer') {
                $this->logUserActivity($user, 'login', 'User logged in to public view successfully');

                // Fetch all candidates
                $candidates = Candidate::all();
                $totalCandidate = User::where('hall', auth()->user()->hall)->where('role', 'voter')->count();

                // Get the authenticated user's hall (if logged in)
                $hall = auth()->check() ? auth()->user()->hall : null;

                $keyword = "CIPHER";

                // Process each candidate
                foreach ($candidates as $candidate) {
                    $poll = Poll::find($candidate->poll_id); // Find candidate's poll
                    
                    if ($poll) {
                        $pollSetting = PollSettings::where('poll_id', $poll->id)->first(); // Find poll settings
                        // dd( $pollSetting );
                        if ($pollSetting) {
                            if ($pollSetting->hide_profile_pictures){
                                $candidate->image_path ="special_voting.jpg";
                            if ($pollSetting->hash_voter_names_numbers) {
                            //    dd($pollSetting->hash_voter_names_numbers);
                                $candidate->team_name = $this->encrypt_to_numbers($candidate->team_name, $keyword);
                            } elseif ($pollSetting->hash_voter_names_Alphabet) {
                                $candidate->team_name = $this->encrypt_to_alphabet($candidate->team_name, $keyword);
                            }
                        }
                        }
                    }
                }

                // Pass data to the view
                return view('livewire.public-room', [
                    'candidates' => $candidates,
                    'hall' => $hall,
                    'totalCandidate' => $totalCandidate,
                ]);
            }
            elseif ($user->role === 'moderator') {
                return redirect(URL::obfuscated('/super-strongroom'));  
            }
            elseif($user->role === 'super_moderator'){
                return redirect(URL::obfuscated('staff-strongroom'));  
            }
        }


        return redirect()->back()->with('error','Invalid credentials');
    }

    /**
     * Generates a key of the same length as the text by repeating the keyword.
     */
    private function generate_key($text, $keyword)
    {
        $keyword = strtoupper($keyword);
        $key = [];
        $key_index = 0;

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            if (ctype_alpha($char)) { // Only consider alphabetic characters for the key
                $key[] = $keyword[$key_index % strlen($keyword)];
                $key_index++;
            } else {
                $key[] = $char; // Keep spaces and special characters unchanged
            }
        }

        return implode('', $key);
    }

    /**
     * Encrypts a message using the Vigenère Cipher and converts letters to numbers.
     */
    private function encrypt_to_numbers($text, $keyword)
    {
        $text = strtoupper($text);
        $key = $this->generate_key($text, $keyword);
        $encrypted_text = [];

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $key_char = $key[$i];

            if (ctype_alpha($char)) {
                $shift = ord($key_char) - ord('A');
                $encrypted_char = (ord($char) - ord('A') + $shift) % 26;
                $encrypted_text[] = (string)$encrypted_char;
            } else {
                $encrypted_text[] = $char; // Keep special characters unchanged
            }
        }

        return implode(' ', $encrypted_text);
    }

    /**
     * Encrypts a message using a simple alphabet shift cipher.
     */
    private function encrypt_to_alphabet($text, $keyword)
    {
        $text = strtoupper($text);
        $key = $this->generate_key($text, $keyword);
        $encrypted_text = [];

        for ($i = 0; $i < strlen($text); $i++) {
            $char = $text[$i];
            $key_char = $key[$i];

            if (ctype_alpha($char)) {
                $shift = ord($key_char) - ord('A');
                $new_char = chr(((ord($char) - ord('A') + $shift) % 26) + ord('A'));
                $encrypted_text[] = $new_char;
            } else {
                $encrypted_text[] = $char; // Keep spaces and special characters unchanged
            }
        }

        return implode('', $encrypted_text);
    }

    /**
     * Logs user activity.
     */
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
