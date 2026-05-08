<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\URL;

class GoogleAuthController extends Controller
{
    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            // Get the user from Google
            $googleUser = Socialite::driver('google')->user();

            // Check if the user already exists in your database
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update the existing user's information
                $user->update([
                    'password' => bcrypt($user->DOB), // Save the user's Google ID
                    'action' => 'verified', // Update the user's action status
                ]);

              

                // Log the user activity
                $this->logUserActivity($user, 'voter status', $user->name . ', Your voter status has been successfully verified!');

                // Redirect with a success message
               // return redirect()->route('feedback')->with('success', 'Your voter status has been successfully verified!');
                return redirect(URL::obfuscated('feedback'))->with('success', 'Your voter status has been successfully verified!');  
            } else {
                // If the user doesn't exist, return an error
                //return redirect()->route('feedback')->withErrors(['error' => 'User not found. Please contact support.']);
                return redirect(URL::obfuscated('feedback'))->withErrors(['error' => 'User not found. Please contact support.']);
            }

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google OAuth Error: ' . $e->getMessage());

            // Handle errors
           // return redirect()->route('feedback')->withErrors(['error' => 'Unable to login with Google. Please try again.']);
            return redirect(URL::obfuscated('feedback'))->withErrors(['error' => 'Unable to login with Google. Please try again.']);
        }
    }

    // Log user activity
    protected function logUserActivity(User $user, string $action, string $details)
    {
        UserActivity::create([
            'session_id' => session()->getId(),
            'user_id' => $user->id,
            'school_id' => $user->school_id, // Ensure this field exists in your UserActivity model
            'action' => $action,
            'details' => $details,
            'ip_address' => request()->ip(), // Get the user's IP address
            'user_agent' => request()->userAgent(), // Get the user's browser user agent
        ]);
    }
}