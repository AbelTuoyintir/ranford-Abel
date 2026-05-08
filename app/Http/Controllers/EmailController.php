<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    //
  

    public function verifyVoter($token)
    {
        // Find the voter by verification token
        $voter = User::where('email_verification_token', $token)->first();
    
        if (!$voter) {
            return redirect()->route('feedback')->withErrors(['error' => 'Invalid or expired verification link.']);
        }
    
        // Check if the token has expired
        if (!$voter->email_verification_expires_at || Carbon::now()->greaterThan($voter->email_verification_expires_at)) {
            $this->logUserActivity($voter, 'voter status', 'Verification link has expired.');
            return redirect()->route('feedback')->withErrors(['error' => 'Verification link has expired. Please request a new one.']);
        }
    
        // Verify the voter and reset the token
        $voter->action = 'verified';
        $voter->email_verification_token = null;
        $voter->email_verification_expires_at = null;
        $voter->save();
    
        $this->logUserActivity($voter, 'voter status', $voter->firstName.' '.$voter->lastName.', Your voter status has been successfully verified!');
    
        // Redirect with a success message
        return redirect()->route('feedback')->with('success', 'Your voter status has been successfully verified!');
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
