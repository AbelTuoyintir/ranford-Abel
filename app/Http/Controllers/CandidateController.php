<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\portfolios;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    //
    
    
    

  public function GetPollCandidate(Request $request){
     // Fetch candidates related to the specific poll
     $pollId= $request->query('pollId');
     $candidates = Candidate::where('poll_id', $pollId)->get();

     // Return as JSON response
     return response()->json($candidates);
  }

  public function deleteCandidate($id)
{
    $user = Auth::user();
    $candidate = Candidate::find($id);

    if ($candidate) {
        $candidate->delete();
        return response()->json(['success' => true, 'message' => 'Candidate deleted successfully']);
        $this->logUserActivity($user, 'candidates',$user->firstName . ' ' . $user->lastName .' deleted '. $candidate->first_name.' '. $candidate->middle_name.' '.$candidate->last_name . ' successfully!');
    } else {
        $this->logUserActivity($user, 'candidates',$user->firstName . ' ' . $user->lastName .' error in deleting  '. $candidate->first_name.' '. $candidate->middle_name.' '.$candidate->last_name );
        return response()->json(['success' => false, 'message' => 'Candidate not found']);
    }
}
    
    
    
    
    
    public function AddCandidate(Request $request)
{
    // dd($request);
    $user = Auth::user();
    // Validate the incoming request
    $request->validate([
        'candidates.*.first_name' => 'required|string|max:255',
        'candidates.*.middle_name' => 'nullable|string|max:255',
        'candidates.*.last_name' => 'required|string|max:255',
        'candidates.*.ballot_number' => 'required',
        'candidates.*.teaser' => 'required|string|max:255',
        'candidates.*.team_name' => 'required|string|max:255',
        'candidates.*.cgpa' => 'required',
        'candidates.*.hall' => 'required',
        'candidates.*.biography' => 'required|string',
        // 'poll_id' => 'required',
        // 'password'=>'required',
        'candidates.*.index_number' => 'required|string|max:255',
        'candidates.*.ghana_card_id' => 'required',  
        'candidates.*.image_path' => 'required|image|mimes:jpeg,png,jpg',
    ]);
   
    $PortfolioId = portfolios::where('name', $request->portfolios)->value('id');
    // dd($request);
    //save the candidate

    foreach ($request->candidates as $candidate) {
       
        $candidate = (object) $candidate;
        
        $pollId = preg_replace('/[^0-9]/', '', $request->poll_id);
        $imagePath = $candidate->image_path->store('candidates', 'public');
        $candidate = Candidate::create([
            'first_name' => $candidate->first_name,
            'middle_name' => $candidate->middle_name,
            'last_name' => $candidate->last_name,
            'ballot_number' => $candidate->ballot_number,
            'teaser' => $candidate->teaser,
            'cgpa' => $candidate->cgpa,
            'team_name'=>$candidate->team_name,
            'portfolio_id'=> $PortfolioId,
            'biography' => $candidate->biography,
            'ghana_card_id' => $candidate->ghana_card_id,
            'image_path' => $imagePath,
            'poll_id' => $pollId,
            'password'=>bcrypt($request->password),
            'hall'=>$candidate->hall,
            'school_id'=>$candidate->index_number,
            'role'=>"candidate",
        ]);
        $this->logUserActivity($user, 'candidates',$user->firstName . ' ' . $user->lastName .' added '. $candidate->first_name.' '. $candidate->middle_name.' '.$candidate->last_name . ' added successfully!');

    }


   return back()->with('success', 'candidate added successfully!');


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

