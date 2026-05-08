<?php

namespace App\Http\Controllers;

use App\Models\Poll;
use App\Models\User;
// use App\Models\candidate;
use App\Models\PollSettings;
use Illuminate\Http\Request;
use App\Models\UserActivity; 
use Illuminate\Support\Facades\DB;
use App\Events\LogUserToStrongRoom;
use App\Events\UpdateNonVoterCount;
use App\Models\candidate_coalition;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\LogUserOutFromStrongRoom;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request inputs
        $fields = $request->validate([
            'school_id' => ['required'],
            'password' => ['required'],
        ]);

        // Retrieve user by school_id
        $user = User::where('school_id', $fields['school_id'])->first();

        if(!$user){
           
            return back()->with('error', 'User  is not in our records .');
        }
        // Check if user exists and the password is correct
        if ($user && Hash::check($fields['password'], $user->password)) {
            // Log the user in
            Auth::login($user);

        // Save session data to ensure it's written to the database
        session()->put('user_id', $user->id); // Store user ID in the session
        session()->save(); // Save the session to the database

        // Update the session status to active
        $sessionId = session()->getId(); // Get the current session ID
        DB::table('sessions')
            ->where('id', $sessionId)
            ->update(['status' => 'active']);

            // Log the login activity
         

            // Check the role of the user and redirect accordingly
            if ($user->role === 'admin') {
                $this->logUserActivity($user, 'login', 'User logged in successfully');
                //return redirect()->route('/dashboard'); // Redirect to admin dashboard
                 return redirect('/dashboard');
            } elseif ($user->role === 'verification_officer') {
               
                $this->logUserActivity($user, 'login', 'User logged in successfully');
                //return redirect()->route('/verification'); // Redirect to moderator dashboard
                return redirect('/verification');
            } 
            elseif ($user->role === 'moderator') {
               
                $this->logUserActivity($user, 'login', 'User logged in successfully');
                //return redirect()->route('/strong-room'); // Redirect to moderator dashboard
                return redirect('/strong-room');
            }
            else {
                // Log the logout activity for invalid role
                Auth::logout();
                $this->logUserActivity($user, 'failed', 'User logged out due to unrecognized role');
                return back()->with('error', 'User role is not recognized.');
            }
        } else {
            // If authentication fails
            Auth::logout();
            $this->logUserActivity($user, 'failed', 'The provided credentials do not match our records.');
            return back()->with('error', 'The provided credentials do not match our records.');
        }
    }
    public function loginCandidate(Request $request)
    {
        // Validate the request inputs
        $fields = $request->validate([
            'school_id' => ['required', 'string'], // Ensure school_id is a string
            'password' => ['required', 'string'], // Ensure password is a string
        ]);
    
        // Retrieve candidate by school_id
        // $candidate = candidate_coalition::get();
        // dd($candidate );
        $candidate = candidate_coalition::where('school_id', $fields['school_id'])->first();
    
        // Check if the candidate exists
        if (!$candidate) {
            return back()->with('error', 'User is not in our records.');
        }
    
        // Verify the password
        if (!Hash::check($fields['password'], $candidate->password)) {
            // Log failed login attempt
            $this->logUserActivity($candidate, 'failed', 'The provided credentials do not match our records.');
            return back()->with('error', 'The provided credentials do not match our records.');
        }
    
        // Log the candidate in using the candidate guard
        Auth::guard('candidates')->login($candidate);
    
        // Save session data
        session()->put('user_id', $candidate->id); // Store candidate ID in the session
        session()->save(); // Save the session to the database
    
        // Update the session status to active
        $sessionId = session()->getId(); // Get the current session ID
        DB::table('sessions')
            ->where('id', $sessionId)
            ->update(['status' => 'active']);
    
        // Log the login activity
        $this->logUserActivity($candidate, 'login', 'User logged in successfully');
    
        // Redirect based on the candidate's role
        if ($candidate->role === 'candidate') {
           // return redirect()->route('/camp'); // Redirect to candidate dashboard
            return redirect('/camp');    
        } else {
            // Log the logout activity for invalid role
            Auth::guard('candidates')->logout();
            $this->logUserActivity($candidate, 'failed', 'User logged out due to unrecognized role');
            return back()->with('error', 'User role is not recognized.');
        }
    }

    

    public function loginVoter(Request $request)
    {
        // Validate the request inputs
        $fields = $request->validate([
            'school_id' => ['required'],
            'password' => ['required'],
        ]);

        // Retrieve user by school_id
        $user = User::where('school_id', $fields['school_id'])->first();
        if(!$user){
           
            return back()->with('error', 'User  is not in our records .');
        }
        // Check if user exists and the password is correct
      
        if ($user && Hash::check($fields['password'], $user->password)) {
            // Log the user in
            Auth::login($user);

            // Save session data to ensure it's written to the database
        session()->put('user_id', $user->id); // Store user ID in the session
        session()->save(); // Save the session to the database

        // Update the session status to active
        $sessionId = session()->getId(); // Get the current session ID
        DB::table('sessions')
            ->where('id', $sessionId)
            ->update(['status' => 'active']);

            // Log the login activity
            

            // Check the role of the user and redirect accordingly
            if ($user->role === 'voter') {
                if($user->action==='verified'){
                    
                    $this->logUserActivity($user, 'login', 'User logged in successfully as voter');
                    broadcast(new LogUserToStrongRoom($user->school_id, $user->image,$user->hall,'login')); 
                    return redirect('/display/voting-card');   
                    
                }
                elseif($user->action==='voted'){
                    $this->logUserActivity($user, 'failed', 'User has already voted!');
                    return back()->with('error', 'User has already voted!.');
                }
                else{
                    $this->logUserActivity($user, 'failed', 'User logged out because the person isnt verified!');
                    return back()->with('error', 'User logged out because the person isnt verified!.');
                }
                
            } else {
                // Log the logout activity for invalid role
                
                $this->logUserActivity($user, 'failed', 'User logged out due to unrecognized role');
                return back()->with('error', 'User logged out due to unrecognized role.');
            }
        } else {
            // If authentication fails
            $this->logUserActivity($user, 'failed', 'User logged out the provided credentials do not match our records');
            return back()->with('error', 'The provided credentials do not match our records.');
        }
    }


    public function logout(Request $request)
    {
        // Check if the user is authenticated as a voter or candidate
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user(); // Voter
            $guard = 'web';
        } elseif (Auth::guard('candidates')->check()) {
            $user = Auth::guard('candidates')->user(); // Candidate
            $guard = 'candidates';
        } else {
            // No authenticated user found
            return back()->with('error', 'No authenticated user found.');
        }
    
        // Log the logout activity
        if ($user) {
            $this->logUserActivity($user, 'logout', 'User logged out');
        }
    
        // Perform role-specific actions
        if ($user->role === 'voter') {
            // Count non-voters
            $nonVoterCount = User::where('action', '!=', 'voted')->count();
    
            // Broadcast events for voters
            broadcast(new UpdateNonVoterCount($user->hall, $nonVoterCount));
            broadcast(new LogUserOutFromStrongRoom($user->school_id, $user->hall));
        }
    
        // Logout the user using the appropriate guard
        Auth::guard($guard)->logout();
    
        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect based on the user's role
        if ($guard === 'web') {
            return redirect('/')->with('success', 'Logged out successfully.');
        } else {
            return redirect('/')->with('success', 'Logged out successfully.');
        }
    }
protected function logUserActivity($user, string $action, string $details)
{
    if ($user instanceof User || $user instanceof candidate_coalition) {
        Log::info('Logging activity for user:', [
            'user_id' => $user->id,
            'school_id' => $user->school_id,
            'action' => $action,
            'details' => $details,
        ]);

        UserActivity::create([
            'session_id' => session()->getId(),
            'user_id' => $user instanceof User ? $user->id : null, // Set user_id to NULL for candidates
            'school_id' => $user->school_id,
            'action' => $action,
            'details' => $details,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    } else {
        Log::error("Invalid user type provided to logUserActivity.");
    }
}


public function showLogs()
{
  
    // Get session data from the database
    $sessions = DB::table('sessions')->orderByDesc('last_activity')->get();
 

    return view('livewire.admin.log', ['sessions'=>$sessions]);
}

public function showDetails(){
    $user_activities=UserActivity::orderByDesc('id')->get();
    return view('livewire.admin.details', ['user_activities'=>$user_activities]);
}

}

