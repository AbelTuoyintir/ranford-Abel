<?php

namespace App\Http\Controllers;

use queue;
use App\Models\Poll;
use App\Models\User;
use App\Models\Votes;
use App\Models\Candidate;
use App\Models\Portfolios;
use App\Events\VoteUpdated;
use App\Models\PollSettings;
use App\Models\UserActivity;

use Illuminate\Http\Request;
use App\Mail\VoteConfirmation;
use App\Events\UpdateVoterCount;
use App\Events\UpdateSkippedCount;
use Illuminate\Support\Facades\DB;
use App\Events\LogUserToStrongRoom;
use App\Events\UpdateNonVoterCount;
use Illuminate\Support\Facades\Mail;
use App\Events\LogUserOutFromStrongRoom;

class VotersController extends Controller
{

    
    public function displayCards()
{
    $user = auth()->user();
    $polls = Poll::where('status', 'active')
        ->where(function ($query) use ($user) {
            // Include general voting for students
            $query->where('poll_type', 'UCC GENERAL VOTING')
                // Include department polls matching user's program
                ->orWhere(function ($query) use ($user) {
                    $query->where('poll_type', 'DEPARTMENT')
                        ->whereHas('pollSettings', function ($q) use ($user) {
                            $q->where('querystring', $user->Programs);
                        });
                })
                // Include hall polls matching user's hall
                ->orWhere(function ($query) use ($user) {
                    $query->where('poll_type', 'HALL')
                        ->whereHas('pollSettings', function ($q) use ($user) {
                            $q->where('querystring', $user->hall);
                        });
                })
                // Include special voting for staff
                ->orWhere(function ($query) use ($user) {

                    $query->where('poll_type', 'SPECIAL VOTING');
                });
        })
        ->with('pollSettings')
        ->get();

    return view('livewire.admin.display-polls-for-voting', ['polls' => $polls]);
}
    
    
    
    public function voterPage($pollType)
{
    $user = auth()->user();
    $hashedUserId = $user->id;

    // Get all active polls the user is eligible to vote in
    $activePolls = Poll::where('status', 'active')
        ->where(function ($query) use ($user) {
            // Always include UCC GENERAL VOTING
            $query->where('poll_type', 'UCC GENERAL VOTING')
                // Include polls for the user's hall or program only
                ->orWhere(function ($query) use ($user) {
                    $query->whereIn('poll_type', ['HALL', 'DEPARTMENT', 'SPECIAL VOTING'])
                        ->whereHas('pollSettings', function ($q) use ($user) {
                            $q->where('querystring', $user->hall)
                              ->orWhere('querystring', $user->Programs);
                        });
                });
        })
        ->get();
        // dd($activePolls);
    // Check if the user has voted in all their eligible active polls
    $hasVotedInAllPolls = true;
    foreach ($activePolls as $poll) {
        $existingVote = votes::where('poll_id', $poll->id)
            ->where('user_id', $hashedUserId)
            ->exists();

        // If the user hasn't voted in at least one poll, set $hasVotedInAllPolls to false
        if (!$existingVote) {
            $hasVotedInAllPolls = false;
            break; // No need to continue checking
        }
    }

    // If the user has voted in all their eligible active polls, log them out
    if ($hasVotedInAllPolls) {
        // Update the user's status to "voted"
        $user->update([
            'action' => 'voted',
        ]);

        // Broadcast the updated voter count
        if ($user->role === "voter") {
            $voterCount = User::where('hall', $user->hall)->where('action', 'voted')->count();
            broadcast(new UpdateVoterCount($user->hall, $voterCount));

            // Broadcast the updated non-voter count
            $nonVoterCount = User::where('action', '!=', 'voted')->where('hall', $user->hall)->count();
            broadcast(new UpdateNonVoterCount($user->hall, $nonVoterCount));
        }

        // Log the user out
        auth()->logout();

        // Log the user activity
        $this->logUserActivity($user, 'Logout', 'You have completed voting in all eligible polls. You have been logged out.');

        // Redirect to the login page with a success message
        session()->flash('success', 'You have completed voting in all eligible polls. You have been logged out.');
        return redirect('/login-student');
    }

    // Get active polls for the current poll type
    $activePollsForCurrentType = Poll::where('status', 'active')
        ->where(function ($query) use ($pollType, $user) {
            $query->where('poll_type', $pollType);

            // For HALL, DEPARTMENT, SPECIAL VOTING, filter by user's hall or program
            if (in_array($pollType, ['HALL', 'DEPARTMENT', 'SPECIAL VOTING'])) {
                $query->whereHas('pollSettings', function ($q) use ($user) {
                    $q->where('querystring', $user->hall)
                      ->orWhere('querystring', $user->Programs);
                });
            }
        })
        ->with('candidates')
        ->get();
    //dd($activePollsForCurrentType);
    // Get all candidates and portfolios for the current poll type

    if($pollType=="HALL"){
       // dd($pollType);
        $candidates = candidate::where('hall',$user->hall)->get();  
    }else{
        $candidates = candidate::get();
    }
    
    //  $candidates = candidate::get();
    //
    $portfolios = portfolios::where('type', $pollType)->get();

    // Get inactive polls for the current poll type
    $inactivePolls = Poll::where('status', 'inactive')
        ->where('poll_type', $pollType)
        ->with('candidates')
        ->get();

    // Check if the user has voted in any active poll of the current type
    $hasVoted = false;
    foreach ($activePollsForCurrentType as $poll) {
        $existingVote = votes::where('poll_id', $poll->id)
            ->where('user_id', $hashedUserId)
            ->exists();

        if ($existingVote) {
            $hasVoted = true;
            break; // No need to continue checking
        }
    }

    // If the user has already voted in the current poll type, show an error message
    if ($hasVoted) {
        session()->flash('error', 'You have already voted in this poll.');
        $this->logUserActivity($user, 'vote', 'You have already voted in this poll');
        //  return redirect('/login-student');
        //return redirect('/login-student');
        return view('livewire.admin.display-polls-for-voting', ['polls' => $activePolls]);
    }

    // Return the voter page with the necessary data
    return view('livewire.admin.voter', [
        'activePolls' => $activePollsForCurrentType,
        'portfolios' => $portfolios,
        'candidates' => $candidates,
    ]);
}
    


public function submitVote(Request $request)
{
    //dd(request()->all());
    // Validate the request
    $validated = $request->validate([
        'votes' => 'required|array',
        'user_id' => 'required|exists:users,id',
    ]);

    
    // Step 1: Retrieve the poll data from the request
    $polls = $request->input('poll');

    // Step 2: Decode the JSON string into an array (if not already an array)
    if (is_string($polls)) {
        $polls = json_decode($polls, true);
    }

    // Step 3: Check if the JSON was decoded successfully
    if (!is_array($polls) || json_last_error() !== JSON_ERROR_NONE) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid poll data.',
        ], 400);
    }

    // Step 4: Retrieve the ID of the first poll
    if (!empty($polls) && isset($polls[0]['id'])) {
        $pollId = $polls[0]['id'];
    } else {
        return response()->json([
            'success' => false,
            'message' => 'No poll data found.',
        ], 404);
    }

    try {
        DB::beginTransaction();

        // Array to store the candidates the user voted for
        $votedCandidates = [];

        // Iterate through the votes and save them
        foreach ($validated['votes'] as $portfolioId => $candidateId) {
            // Handle "skip" option
            if ($candidateId === 'skip') {
                // Record the "skip" vote
                $portfolios = Portfolios::find($portfolioId);
                Votes::create([
                    'poll_id' => $pollId,
                    'candidate_id' => null, // No candidate selected
                    'user_id' => $validated['user_id'], 
                    'poll_type' => $portfolios->name, 
                    'votes' => 0, 
                    'votes_status' => 'skipped' 
                ]);
            } else {
                // Fetch the candidate
                $candidate = Candidate::find($candidateId);
                if (!$candidate) {
                    throw new \Exception("Candidate with ID $candidateId not found.");
                }

                // Get the portfolio type
                $portfolios = Portfolios::find($candidate->portfolio_id);
                if (!$portfolios) {
                    throw new \Exception("Portfolio with ID {$candidate->portfolio_id} not found.");
                }

                // Save the vote
                votes::create([
                    'poll_id' => $pollId,
                    'candidate_id' => $candidateId,
                    'user_id' => $validated['user_id'],
                    'poll_type' => $portfolios->name, 
                    'votes' => 1, 
                    'votes_status' => 'voted' 
                ]);

                // Add to voted candidates array
                $votedCandidates[] = $candidate;

                $poll = Poll::find($candidateId);
                $voteCount = votes::where('candidate_id', $candidateId)->count();
               
               broadcast(new VoteUpdated($candidateId, $voteCount));
            }
        }
        
        DB::commit();

        // Send confirmation email
        $ipAddress = $request->ip();
        $user = User::find($validated['user_id']);
        if ($poll) {
                    $pollSetting = PollSettings::where('poll_id', $poll->id)->first(); // Find poll settings
                    if ($pollSetting) {
                        if ($pollSetting->send_result_slips){
                            // Broadcast the updated vote count for the candidate
                            Mail::to($user->email)->queue(new VoteConfirmation($user, $polls[0], $votedCandidates, $ipAddress));
                            $this->logUserActivity($user, 'email', 'Voter slip email sent successfully.');
                            
                        }
                    }
                }

        

        // Check if the user has voted in all eligible active polls
        $allEligiblePolls = Poll::where('status', 'active')
            ->where(function ($query) use ($user) {
                $query->where('poll_type', 'UCC GENERAL VOTING') // Always include UCC GENERAL VOTING
                    ->orWhere(function ($query) use ($user) {
                        $query->whereIn('poll_type', ['HALL', 'DEPARTMENT', 'SPECIAL VOTING'])
                            ->whereHas('pollSettings', function ($query) use ($user) {
                                $query->where(function ($q) use ($user) {
                                    $q->where('querystring', $user->hall)
                                        ->orWhere('querystring', $user->Programs);
                                });
                            });
                    });
            })
            ->get();

        $hasVotedInAllPolls = true;
            foreach ($allEligiblePolls as $poll) {
                $existingVote = Votes::where('poll_id', $poll->id)
                ->where('user_id', $validated['user_id'])
                ->whereIn('votes_status', ['voted', 'skipped'])
                ->exists();

                if (!$existingVote) {
                    $hasVotedInAllPolls = false;
                    break; // No need to continue checking
                }
            }

        // If the user has voted in all eligible polls, log them out and update their status
        if ($hasVotedInAllPolls) {
            // Update the user's status to "voted"
            $user->update([
                'action' => 'voted',
            ]);

            if ($user->role === "voter") {
                // Broadcast the updated voter count for the user's hall
                $voterCount = User::where('hall', $user->hall)->where('action', 'voted')->count();
                broadcast(new UpdateVoterCount($user->hall, $voterCount));

                // Broadcast the updated non-voter count
                $nonVoterCount = User::where('action', '!=', 'voted')->where('role', $user->role)->where('hall', $user->hall)->count();
                broadcast(new UpdateNonVoterCount($user->hall, $nonVoterCount));

                broadcast(new LogUserOutFromStrongRoom($user->school_id, $user->hall));
                $skippedVotes = votes::where('votes_status', 'skipped')->count();
                broadcast(new UpdateSkippedCount($user->hall, $skippedVotes));
            
            }

            // Log the user out
            auth()->logout();

            // Log the user activity
            $this->logUserActivity($user, 'Logout', 'You have completed voting in all eligible polls. You have been logged out.');

            // Redirect to the login page with a success message
            session()->flash('success', 'You have completed voting in all eligible polls. You have been logged out.');
            return redirect('/voter-login');
        }

        // If the user has not voted in all polls, show a success message
        $this->logUserActivity($user, 'vote', 'You have successfully voted in this poll.');
        session()->flash('success', 'You have successfully voted in this poll.');
        return view('livewire.admin.display-polls-for-voting', ['polls' => Poll::where('status', 'active')->with('pollSettings')->get()]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Failed to submit votes: ' . $e->getMessage()
        ], 500);
    }
}


private function getPollStats($pollId)
{
    return DB::table('votes')
        ->select(
            'candidates.id',
            'candidates.first_name',
            'candidates.last_name',
            DB::raw('COUNT(CASE WHEN votes.votes_status = "voted" THEN 1 END) as total_votes'),
            DB::raw('COUNT(CASE WHEN votes.votes_status = "skipped" THEN 1 END) as total_skips')
        )
        ->join('candidates', 'candidates.id', '=', 'votes.candidate_id')
        ->where('votes.poll_id', $pollId)
        ->groupBy('candidates.id', 'candidates.first_name', 'candidates.last_name')
        ->get();
}

public function checkUserVoteStatus(Request $request, $pollId)
{
    $hasVoted = votes::where('poll_id', $pollId)
        ->where('user_id', auth()->id())
        ->exists();

    return response()->json([
        'has_voted' => $hasVoted
    ]);
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
