<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{

    public function fetchAndStoreStudentDataAll()
    {
        
        try {
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer 8|U7DLQ3mivEmMqlT3Duhsd1spH6iCglxyp3aObO9S05d4c90d',
                    'Accept' => 'application/json',
                ])
                ->get('https://bsapi.ucc.edu.gh/api/studdata_ind_reg_stud_all', [
                    'limit' => 100 // Fetch only 100 records at a time
                ]);
    
            if ($response->successful()) {
                $students = $response->json();
    
                if (!is_array($students)) {
                    return response()->json(['error' => 'Invalid data format received'], 500);
                }
    
                foreach ($students as $data) {
                    User::updateOrCreate(
                        ['school_id' => $data['regno']], // Unique identifier
                        [
                            'firstName' => $data['fname'] ?? 'Unknown',
                            'middleName' => $data['mname'] ?? null,
                            'lastName' => $data['lname'] ?? 'Unknown',
                            'programs' => $data['program_name'] ?? 'Not Specified',
                            'hall' => $data['hallid'] ?? null,
                            // Remove 'image' if not in API response
                            'sex' => $data['sex'] ?? 'N/A',
                            'email' => $data['email'] ?? null,
                            'DOB' => $data['dob'] ?? null,
                            'phone' => $data['cellphone'] ?? null,
                            'email_verified_at' => now(),
                            'email_verification_token' => Str::random(64),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
    
                return response()->json(['message' => 'Students successfully stored'], 200);
            }
    
            return response()->json(['error' => 'Failed to fetch data'], $response->status());
        } catch (\Exception $e) {
            Log::error('Error fetching student data: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function fetchStudentData()
    {
        $indexNo = "SS/PHL/23/0073"; // Example student index number
        
        // Fetch student data from the API
        // $apiService = new ApiService();
        // $response = $apiService->fetchStudentData($indexNo);

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer 10|ETu95p2HFhqd5ovEMVqQoqBtF4wE4G2BuzXwdUni93ca174e',
                'Accept' => 'application/json',
            ])
            ->post('https://bsapi.ucc.edu.gh/api/studdata_ind_reg_stud', [
                'index_no' => $indexNo,
            ]);
    
            
            if ($response->successful()) {
                $data = $response->json();
        
                // Ensure $data is an array and not empty
                if (is_array($data) && !empty($data)) {
                    $student = $data[0]; // Extract the first student record
        
                    // Insert into the users table
                    $user = User::updateOrCreate(
                        ['school_id' => $student['regno']], // Unique constraint to prevent duplicates
                        [
                            'firstName' => $student['fname'],
                            'middleName' => $student['mname'] ?? null,
                            'lastName' => $student['lname'],
                            'school_id' => $student['regno'],
                            'programs' => $student['program_name'],
                            'hall' => $student['hallid'],
                            'image' => $student['image'] ?? null,
                            'gender' => $student['sex'], //  Include this if your table uses 'gender'
                            'email' => $student['email'] ?? null,
                            'email_verified_at' => now(),
                            'email_verification_token' => Str::random(64),
                            'DOB' => $student['dob'],
                            'phone' => $student['cellphone'] ?? null,
                        ]
                    );
        
                    return response()->json(['message' => 'Student data saved successfully', 'user' => $user]);
                } else {
                    return response()->json(['error' => 'Invalid API response format'], 400);
                }
            } else {
                return response()->json([
                    'error' => 'Error fetching data',
                    'status' => $response->status(),
                    'body' => $response->body()
                ], $response->status());
            }
    }

    public function fetchstudentCGPA(){
        $indexNo = "SS/PHL/23/0073"; // Example student index number
        
        // Fetch student data from the API
        // $apiService = new ApiService();
        // $response = $apiService->fetchStudentData($indexNo);

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer 10|ETu95p2HFhqd5ovEMVqQoqBtF4wE4G2BuzXwdUni93ca174e',
                'Accept' => 'application/json',
            ])
            ->post('https://bsapi.ucc.edu.gh/api/studdata_ind_reg_stud', [
                'index_no' => $indexNo,
            ]);
    
            
            if ($response->successful()) {
                $data = $response->json();
                dd($data);
                // Ensure $data is an array and not empty
                if (is_array($data) && !empty($data)) {
                    $student = $data[0]; // Extract the first student record
                }
            }
    }

    
}

    
