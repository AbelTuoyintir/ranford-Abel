<?php

namespace App\Jobs;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;

class FetchStaffsJob implements ShouldQueue
{
    use  Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('[Staff Sync] Job started');
    
        // API Configuration
        $apiConfig = [
            'login_url' => env('BSAPI_LOGIN_URL'),
            'students_url' => env('BSAPI_STAFF_URL_ALL'),
            'credentials' => [
                'email' => env('BSAPI_EMAIL'),
                'api_key' => env('BSAPI_API_KEY'),
                'password' => env('BSAPI_PASSWORD'),
            ]
        ];
    
        try {
            // Step 1: Authentication
            Log::debug('[Staff Sync] Authenticating with API');
            $loginResponse = Http::withoutVerifying()
                ->post($apiConfig['login_url'], $apiConfig['credentials']);
    
            if (!$loginResponse->successful()) {
                Log::error('[Student Sync] Authentication failed', [
                    'status' => $loginResponse->status(),
                    'response' => substr($loginResponse->body(), 0, 200) // Log first 200 chars
                ]);
                return;
            }
    
            $token = $loginResponse->json('token');
            if (!$token) {
                Log::error('[Staff Sync] Invalid token received');
                return;
            }
    
            // Step 2: Fetch student data
            Log::info('[Staff Sync] Fetching Staff data');
            $response = Http::withoutVerifying()
                ->withToken($token)
                ->get($apiConfig['students_url']);
    
            if (!$response->successful()) {
                Log::error('[Staff Sync] Failed to fetch Staff', [
                    'status' => $response->status()
                ]);
                return;
            }
    
            $students = $response->json();
            if (empty($students)) {
                Log::warning('[Staff Sync] Empty response received');
                return;
            }
    
            // Step 3: Process records
            $stats = ['created' => 0, 'updated' => 0, 'failed' => 0];
    
            foreach ($students as $student) {
                try {
                    $regNo = $student['staff_no'] ?? null;
                    if (!$regNo) {
                        Log::warning('[Student Sync] Missing registration number', ['data' => $student]);
                        $stats['failed']++;
                        continue;
                    }
    
                    $result = User::updateOrCreate(
                        ['school_id' => $regNo],
                        [
                            'firstName' => $student['fname'] ?? null,
                            'middleName' => $student['mname'] ?? null,
                            'lastName' => $student['lname'] ?? null,
                            'programs' => $student['staff_group'] ." ".$student['staff_status']?? null,
                            'hall' =>'SPECIAL',
                            'image' => $student['image'] ?? "https://cdn.ucc.edu.gh/photos/?tag=" . $student['staff_no'],
                            'gender' => $student['gender'] ?? null,
                            'email' => $student['ucc_mail'] ?? $student['email'] ?? null,
                            'action' => 'unverified',
                            'type'=>'staff',
                            'password' => bcrypt('1234'), // Reset password on update
                            'DOB' => $student['dob'] ?? null,
                            'phone' => $student['phone'] ?? null,
                        ]
                    );
    
                    $result->wasRecentlyCreated ? $stats['created']++ : $stats['updated']++;
                    
                    Log::debug('[Staff Sync] Processed staff', [
                        'regno' => $regNo,
                        'action' => $result->wasRecentlyCreated ? 'created' : 'updated'
                    ]);
    
                } catch (\Exception $e) {
                    Log::error('[Staff Sync] Failed to process Staff', [
                        'regno' => $regNo ?? 'UNKNOWN',
                        'error' => $e->getMessage()
                    ]);
                    $stats['failed']++;
                }
            }
    
            Log::info('[Staff Sync] Job completed', [
                'stats' => $stats,
                'total_processed' => count($students)
            ]);
        } catch (\Exception $e) {
            Log::error('[Staff Sync] Job failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
