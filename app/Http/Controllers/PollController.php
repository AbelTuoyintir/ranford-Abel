<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\poll;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PollController extends Controller
{
    //
    public function StartElection(){
        $user = Auth::user();
        $this->logUserActivity($user, 'Start Election', 'User started the election successfully!');
        // Activate all polls
        Poll::query()->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Elections started. All polls are now active.');
    }

    public function StopElection(){
        $user = Auth::user();
        $this->logUserActivity($user, 'Stop Election', 'User stopped the election successfully!');
        // Deactivate all polls
        Poll::query()->update(['status' => 'complete']);

        return redirect()->back()->with('success', 'Elections stopped. All polls are now complete.');
    }
    
    
    
    
    
    
    
    
    public function CreatePoll(Request $request)
{
   
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'start_time' => 'required|before:end_time',
        'end_time' => 'required|after:start_time',
        'start_date' => 'required',
        'poll_type' => 'required',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);
    
   
    // Generate folder path based on title and current year
    $currentYear = now()->year;
    $validated['title'] = $request->title . ' ' . $currentYear;
    $folderName = 'election/' . str_replace(' ', '_', $request->title) . '_' . $currentYear;

    // Handle image upload
    if ($request->hasFile('image')) {
        
        $validated['image'] = $request->file('image')->store($folderName, 'public');
        
    }else{
       
        if($validated['poll_type']==='UCC GENERAL VOTING')
            $validated['image'] ="default_image/ucc_general_voting.jpg";
        elseif($validated['poll_type']==='DEPARTMENT')
        $validated['image'] = "default_image/department.jpg";
        elseif($validated['poll_type']==='SPECIAL VOTING')
        $validated['image'] ="default_image/special_voting.jpg";
        elseif($validated['poll_type']==='HALL')
        $validated['image'] ="default_image/hall.jpg";

    }

    $validated['status']='inactive';

    // Create the poll

    $user = Auth::user();
    $this->logUserActivity($user, 'Poll creation', 'User created a poll successfully!');
    Poll::create($validated);

    return back()->with('success', 'Poll created successfully!');
}

// public function getEligibleVoters(Request $request){
//     $request->validate([
//         'database_type' => 'required|string',
//         'database_value' => 'required|string',
//     ]);
// }

public function getPollCounts()
{
    // Count polls by status
    $candidate= Candidate::get();
    $activePolls = Poll::where('status', 'active')->count();
    $inactivePolls = Poll::where('status', 'inactive')->count();
    $completePolls = Poll::where('status', 'complete')->count();

    // Total polls
    $totalPolls = Poll::count();
   
    //all polls
    $Polls = Poll::get();
   

    // Return the data (e.g., to a view or as JSON for an API)
    return view('livewire.admin.create-poll', [
        'activePolls' => $activePolls,
        'inactivePolls' => $inactivePolls,
        'completePolls' => $completePolls,
        'totalPolls' => $totalPolls,
        'Polls' => $Polls,
        'candidate'=>$candidate
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
