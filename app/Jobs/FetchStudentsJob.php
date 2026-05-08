<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchStudentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}


        public function handle()
        {
            Log::info('[Student Sync] Job started');
        
            // API Configuration
            $apiConfig = [
                'login_url' => "https://bsapi.ucc.edu.gh/api/login",
                'students_url' => "https://bsapi.ucc.edu.gh/api/studdata_ind_reg_stud_all",
                'credentials' => [
                    'email' => env('BSAPI_EMAIL'),
                    'api_key' => env('BSAPI_API_KEY'),
                    'password' => env('BSAPI_PASSWORD'),
                ]
            ];
        
            try {
                // Step 1: Authentication
                Log::debug('[Student Sync] Authenticating with API');
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
                    Log::error('[Student Sync] Invalid token received');
                    return;
                }
        
                // Step 2: Fetch student data
                Log::info('[Student Sync] Fetching student data');
                $response = Http::withoutVerifying()
                    ->withToken($token)
                    ->get($apiConfig['students_url']);
        
                if (!$response->successful()) {
                    Log::error('[Student Sync] Failed to fetch students', [
                        'status' => $response->status()
                    ]);
                    return;
                }
        
                $students = $response->json();
                if (empty($students)) {
                    Log::warning('[Student Sync] Empty response received');
                    return;
                }
        
                // Step 3: Process records
                $stats = ['created' => 0, 'updated' => 0, 'failed' => 0];
        
                foreach ($students as $student) {
                    try {
                        $regNo = $student['regno'] ?? null;
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
                                'programs' => $student['program_name'] ?? null,
                                'hall' => $student['hallid'] ?? null,
                                'image' => $student['image'] ?? "https://cdn.ucc.edu.gh/photos/?tag=" . $regNo,
                                'gender' => $student['sex'] ?? null,
                                'email' => $student['inst_email'] ?? $student['email'] ?? null,
                                'action' => 'unverified',
                                'type'=>'student',
                                'password' => bcrypt('1234'), // Reset password on update
                                'DOB' => $student['dob'] ?? null,
                                'phone' => $student['cellphone'] ?? null,
                            ]
                        );
        
                        $result->wasRecentlyCreated ? $stats['created']++ : $stats['updated']++;
                        
                        Log::debug('[Student Sync] Processed student', [
                            'regno' => $regNo,
                            'action' => $result->wasRecentlyCreated ? 'created' : 'updated'
                        ]);
        
                    } catch (\Exception $e) {
                        Log::error('[Student Sync] Failed to process student', [
                            'regno' => $regNo ?? 'UNKNOWN',
                            'error' => $e->getMessage()
                        ]);
                        $stats['failed']++;
                    }
                }
        
                Log::info('[Student Sync] Job completed', [
                    'stats' => $stats,
                    'total_processed' => count($students)
                ]);
        
            } catch (\Exception $e) {
                Log::error('[Student Sync] Job failed', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }
}
