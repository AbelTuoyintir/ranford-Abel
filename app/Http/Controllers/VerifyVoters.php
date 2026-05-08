<?php

namespace App\Http\Controllers;

use queue;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Jobs\FetchStaffsJob;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Mail\VerifyVoterEmail;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Events\VerificationVoterFailed;
use App\Events\VerificationVoterUpdate;


class VerifyVoters extends Controller
{
    
    //
    public function GetVoters(){
        $user = Auth::user();
        $voters=User::where('role','voter')->where('hall',$user->hall)->get();
        $votes = User::where('role','voter')->where('hall',$user->hall)->where('action','voted')->get();
        $voters_unverify=User::where('hall',$user->hall)->where('role','voter')->where('action','unverified')->get();
        $voters_verify = User::where('hall', $user->hall)
            ->where('role', 'voter')
            ->where(function($query) {
            $query->where('action', 'verified')
                  ->orWhere('action', 'voted');
            })
            ->get();
        
        return view('livewire.admin.verification', [
            'voters' => $voters,
            'voters_unverify' => $voters_unverify,
            'voters_verify' => $voters_verify,
            'votes'=>$votes
            
      
        ]);
    }

    public function automatic(){
        $user = Auth::user();
        $voters=User::where('role','voter')->get();
        $votes = User::where('role','voter')->where('action','voted')->get();
        $voters_unverify=User::where('hall',$user->hall)->where('role','voter')->where('action','unverified')->get();
        $voters_verify=User::where('hall',$user->hall)->where('role','voter')->where('action','verified')->get();
        
        return view('livewire.admin.automatic-verification', [
            'voters' => $voters,
            'voters_unverify' => $voters_unverify,
            'voters_verify' => $voters_verify,
            'votes'=>$votes
            
      
        ]);
    }

        public function updateAutomatic(Request $request)
        {
            // ⏳ Prevent PHP timeout
    ini_set('max_execution_time', 0);   // 0 = unlimited
    ini_set('request_terminate_timeout', 0); // for PHP-FPM if supported

    // 💾 Prevent session timeout during long execution
    ini_set('session.gc_maxlifetime', 7200); // 2 hours
    session_set_cookie_params(7200);

            $user = Auth::user();

            $sentCount = 0;
            $failedCount = 0;

            // Use query builder chunk to avoid memory issues
            User::where('role', 'voter')
                ->where('action', 'unverified')
                ->where(function ($query) {
                    $query->whereNull('broadcast_status')
                        ->orWhere('broadcast_status', '!=', 'sent');
                })
                ->limit(20000)
                ->chunk(20000, function ($voters) use ($user, &$sentCount, &$failedCount) {
                    
                    $setting = Setting::first(); // more efficient than get()->first()

                    foreach ($voters as $voter) {
                        try {
                            // Generate token + expiration
                            $verificationToken = Str::random(64);
                            $verificationUrl   = route('verify.voter', ['token' => $verificationToken]);
                            $expirationTime    = Carbon::now()->addHours(24);

                            // Generate random password
                            $randomPassword = Str::random(6);

                            // Send notification
                            if ($setting && $setting->notification === "email") {
                                Mail::to($voter->email)->queue(
                                    new VerifyVoterEmail($voter, $verificationUrl, $randomPassword)
                                );
                            } elseif ($setting && $setting->notification === "sms") {
                                $this->sendSmsViaArkesel($voter, $verificationUrl, $randomPassword);
                            }

                            // Update voter record
                            $voter->update([
                                'email_verification_token'     => $verificationToken,
                                'email_verification_expires_at'=> $expirationTime,
                                'password'                     => bcrypt($randomPassword),
                                'broadcast_status'             => 'sent',
                            ]);

                            // Broadcast success
                            broadcast(new VerificationVoterUpdate($voter->school_id, 'sent'));

                            // Log success
                            $this->logUserActivity(
                                $user,
                                'Verification link sent',
                                "{$user->firstName} {$user->lastName} sent a verification link to {$voter->firstName} {$voter->lastName} successfully!"
                            );

                            $sentCount++;
                        } catch (\Exception $e) {
                            // Mark as failed
                            $voter->update(['broadcast_status' => 'failed']);

                            broadcast(new VerificationVoterFailed($voter->school_id, 'failed'));

                            $this->logUserActivity(
                                $user,
                                'Verification link failed',
                                "{$user->firstName} {$user->lastName} failed to send a verification link to {$voter->firstName} {$voter->lastName}. Error: {$e->getMessage()}"
                            );

                            $failedCount++;
                        }

                        usleep(100000); // 0.1s delay
                    }
                });

            return redirect()->back()
                ->with('success', "Verification emails sent: $sentCount | Failed: $failedCount");
        }


protected function sendSmsViaArkesel($voter, $verificationUrl, $password)
{
    try {
        // Validate phone number
        if (empty($voter->phone)) {
            throw new \Exception('Voter has no phone number');
        }

        // Format phone number
        $phoneNumber = '233' . substr($voter->phone, 1);
        
        // Create message
        $message = "Hello {$voter->firstName}, Your UCC voting account is ready. " .
                    "Please click to verify within 24hrs: {$verificationUrl}. ".
                    "Voting Date 14 March. ".
                   "Username: {$voter->school_id} Password: {$password} " .
                   "Link: https://vote.ucc.edu.gh/voter-login";
        // dd($message);

        // Send SMS using HTTP client
        $response = Http::get('https://sms.arkesel.com/sms/api', [
            'action' => 'send-sms',
            'api_key' => env('ARKESEL_API_KEY'),
            'to' => $phoneNumber,
            // 'to' => '0547268141',
            'from' => env('ARKESEL_SENDER_ID', 'UCC-EVOTE'),
            'sms' => $message
        ]);

        // Check response
        $responseData = $response->json();
        
        if ($response->successful() && ($responseData['code'] ?? '') === 'ok') {
            Log::info("SMS sent to {$voter->phone}", [
                'balance' => $responseData['balance'] ?? null,
                'sms_id' => $responseData['sms_id'] ?? null
            ]);
            return true;
        }

        // Handle failure
        $errorMsg = $responseData['message'] ?? 'Unknown error';
        throw new \Exception("SMS failed: {$errorMsg}");

    } catch (\Exception $e) {
        Log::error("SMS error: {$e->getMessage()}");
        throw $e;
    }
}

    public function update(Request $request)
    {
        // Validate the request
        $user = Auth::user();
        $request->validate([
            'schoolId' => 'required|string|exists:users,school_id',
        ]);
    
        // Find the voter by schoolId
        $voter = User::where('school_id', $request->schoolId)->first();
    
        if ($voter && $voter->action !== 'verified') {
            try {
                // Generate a unique verification token and expiration time
                $verificationToken = Str::random(64);
                $verificationExpiresAt = Carbon::now()->addMinutes(30); // Token expires in 30 minutes
    
                // Store the token and expiration time in the database
                $voter->email_verification_token = $verificationToken;
                $voter->email_verification_expires_at = $verificationExpiresAt;
    
                // Generate a random 6-character password
                $randomPassword = Str::random(6);
                $voter->password = bcrypt($randomPassword);
    
                // Generate the verification URL
                $verificationUrl = route('verify.voter', ['token' => $verificationToken]);
    
                // Send the verification email
                Mail::to($voter->email)->queue(new VerifyVoterEmail($voter, $verificationUrl, $randomPassword));
    
                // Update `broadcast_status` to "sent"
                $voter->broadcast_status = 'sent';
                $voter->save();
    
                // Dispatch broadcast event
                broadcast(new VerificationVoterUpdate($voter->school_id, 'sent'));
    
                // Log the activity
                $this->logUserActivity($user, 'Verification link sent', 
                    "{$user->firstName} {$user->lastName} sent a verification link to {$voter->firstName} {$voter->lastName} successfully!");
    
                return redirect()->back()->with('success', 'Verification email sent to the voter!');
            } catch (\Exception $e) {
                // Update `broadcast_status` to "failed" if an error occurs
                $voter->broadcast_status = 'failed';
                $voter->save();
    
                // Dispatch failed event
                broadcast(new VerificationVoterFailed($voter->school_id, 'failed'));
    
                // Log the failure
                $this->logUserActivity($user, 'Verification link failed', 
                    "{$user->firstName} {$user->lastName} failed to send a verification link to {$voter->firstName} {$voter->lastName}. Error: " . $e->getMessage());
    
                return redirect()->back()->withErrors(['error' => 'Failed to send verification email. Please try again.']);
            }
        } elseif ($voter && $voter->action === 'verified') {
            return redirect()->back()->withErrors(['error' => 'Voter already verified']);
        }
    
        // If no voter is found, log and return error
        broadcast(new VerificationVoterFailed($request->schoolId, 'failed'));
        $this->logUserActivity($user, 'Verification link failed', 
            "{$user->firstName} {$user->lastName} failed to send a verification link to voter.");
    
        return redirect()->back()->withErrors(['error' => 'Voter not found']);
    }
    


    public function verify(Request $request)
    {
        // Validate the request
        $user = Auth::user();
        $v=$request->validate([
            'schoolId' => 'required|string|exists:users,school_id',
            'DOB' => 'required|string',
        ]);

        // Find the voter by schoolId
        $voter = User::where('school_id', $request->schoolId)->first(); 

        if ($voter&& $voter->action !== 'verified') {
            if($voter->DOB !== $request->DOB){
                return redirect()->back()->withErrors(['error' => 'Date of birth does not match']);
            }
            $voter->action = 'verified';  
            $voter->password =$voter->DOB;  
            $voter->save();     
            $this->logUserActivity($user, 'Verification successful', $user->firstName . ' ' . $user->lastName . " verification for  ".$voter->firstName.''.$voter->lastName. "was successful!");
            return redirect()->back()->with(['success' => 'Verification successful ']);       
        }
        elseif($voter&& $voter->action === 'verified'){
            return redirect()->back()->withErrors(['error' => 'Voter already verified']);
        }
        else{
            // If no voter is found, redirect back with an error message
         $this->logUserActivity($user, 'Verification link sent', $user->firstName . ' ' . $user->lastName . " verification link to ".$voter->firstName.''.$voter->lastName. "failed!");
         return redirect()->back()->withErrors(['error' => 'Voter not found ']);
        }

    }  

public function import(Request $request)
{
    Log::info('Student import initiated', ['index_no' => $request->index_no]);

    $request->validate(['index_no' => 'required|string']);
    $indexNo = $request->input('index_no');

    // Step 1: API Authentication
    $credentials = [
        'email'    => env('BSAPI_EMAIL'),
        'api_key'  => env('BSAPI_API_KEY'),
        'password' => env('BSAPI_PASSWORD'),
    ];

    try {
        $loginResponse = Http::withoutVerifying()->post(env('BSAPI_LOGIN_URL'), $credentials);
        
        if (!$loginResponse->successful()) {
            Log::error('API login failed', [
                'status' => $loginResponse->status(),
                'response' => $loginResponse->body()
            ]);
            return response()->json(['error' => 'API login failed'], 401);
        }

        $token = $loginResponse->json('token');
        if (!$token) {
            Log::error('Invalid API token received');
            return response()->json(['error' => 'Invalid API token'], 400);
        }

        // Step 2: Fetch Student Data
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])
            ->post(env('BSAPI_STUDENT_URL'), ['index_no' => $indexNo]);

        if (!$response->successful()) {
            Log::error('Failed to fetch student data', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return response()->json(['error' => 'Failed to fetch student data'], $response->status());
        }

        $studentData = $response->json();
        if (empty($studentData)) {
            Log::warning('Empty student data received', ['index_no' => $indexNo]);
            return response()->json(['error' => 'No student data found'], 404);
        }

        $student = $studentData[0];
        Log::debug('Student data fetched', ['regno' => $student['regno']]);

        // Step 3: Update or Create Record
        $user = User::updateOrCreate(
            ['school_id' => $student['regno']],
            [
                'firstName'  => $student['fname'],
                'middleName' => $student['mname'] ?? null,
                'lastName'   => $student['lname'],
                'programs'   => $student['dept_name'],
                'hall'       => $student['hallid'],
                'image'      => $student['image'] ?? "https://cdn.ucc.edu.gh/photos/?tag=" . $student['regno'],
                'gender'     => $student['sex'],
                'email'      => $student['inst_email'] ?? $student['email'] ?? null,
                'action'     => 'unverified',
                'type'        =>'student',
                'password'   => bcrypt('1234'),
                'DOB'        => $student['dob'],
                'phone'      => $student['cellphone'] ?? null,
            ]
        );

        // Log creation/update
        if ($user->wasRecentlyCreated) {
            Log::info('New student created', ['school_id' => $user->school_id]);
        } else {
            Log::info('Student data updated', ['school_id' => $user->school_id]);
        }

        return redirect()->back()->with([
            'success' => 'Student imported successfully!',
            'user'    => $user,
        ]);

    } catch (\Exception $e) {
        Log::error('Student import failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

public function importStaff(Request $request)
{
    Log::info('Student import initiated', ['staff_id' => $request->staff_id]);

    $request->validate(['staff_id' => 'required|string']);
    $indexNo = $request->input('staff_id');

    // Step 1: API Authentication
    $credentials = [
        'email'    => env('BSAPI_EMAIL'),
        'api_key'  => env('BSAPI_API_KEY'),
        'password' => env('BSAPI_PASSWORD'),
    ];

    try {
        $loginResponse = Http::withoutVerifying()->post(env('BSAPI_LOGIN_URL'), $credentials);
        
        if (!$loginResponse->successful()) {
            Log::error('API login failed', [
                'status' => $loginResponse->status(),
                'response' => $loginResponse->body()
            ]);
            return response()->json(['error' => 'API login failed'], 401);
        }

        $token = $loginResponse->json('token');
        if (!$token) {
            Log::error('Invalid API token received');
            return response()->json(['error' => 'Invalid API token'], 400);
        }

        // Step 2: Fetch Student Data
        $response = Http::withoutVerifying()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])
            ->post(env('BSAPI_STAFF_URL'), ['staff_no' => $indexNo]);

        if (!$response->successful()) {
            Log::error('Failed to fetch staff data', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            return response()->json(['error' => 'Failed to fetch staff data'], $response->status());
        }

        $studentData = $response->json();
        if (empty($studentData)) {
            Log::warning('Empty staff data received', ['staff_id' => $indexNo]);
            return response()->json(['error' => 'No staff data found'], 404);
        }

        $student = $studentData[0];
        Log::debug('Staff data fetched', ['staff_id' => $student['staff_no']]);

        // Step 3: Update or Create Record
        
        $user = User::updateOrCreate(
            ['school_id' => $student['staff_no']],
            [
                'firstName'  => $student['fname'],
                'middleName' => $student['mname'] ?? null,
                'lastName'   => $student['lname'],
                'programs'   => $student['staff_group'] ." ".$student['staff_status'] ?? null,
                'hall'       => 'SPECIAL',
                'image'      => $student['image'] ?? "https://cdn.ucc.edu.gh/photos/?tag=" . $student['staff_no'],
                'gender'     => $student['gender'],
                'email'      => $student['ucc_mail'] ?? $student['email'] ?? null,
                'action'     => 'unverified',
                'type'        =>'staff',
                'password'   => bcrypt('1234'),
                'DOB'        => $student['dob']  ?? null ,
                'phone'      => $student['phone'] ?? null,
            ]
        );

        // Log creation/update
        if ($user->wasRecentlyCreated) {
            Log::info('New Staff created', ['school_id' => $user->school_id]);
        } else {
            Log::info('Staff data updated', ['school_id' => $user->school_id]);
        }

        return redirect()->back()->with([
            'success' => 'Staff imported successfully!',
            'user'    => $user,
        ]);

    } catch (\Exception $e) {
        Log::error('Staff import failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Internal server error'], 500);
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