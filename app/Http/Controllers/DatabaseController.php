<?php

namespace App\Http\Controllers;

use App\Jobs\FetchStaffsJob;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\FetchStudentsJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DatabaseController extends Controller
{
   
   public function index(){
        $male=user::where("gender","M")->count();
        $female=user::where("gender","F")->count();
        $users=user::where("role","voter")->get();
        return view("livewire.admin.database",["male"=> $male,"female"=> $female,"users"=> $users]);

   }
   
   
    public function fetchStudents(Request $request)
{
    // Uncomment the following lines if you want to process asynchronously:
    FetchStudentsJob::dispatch();
    return redirect()->back()->with('success', 'Student data is being processed in the background!');

    // Synchronous processing:
    // Step 1: Get Token from API using environment variables
    // $loginUrl = env('BSAPI_LOGIN_URL');
    // $credentials = [
    //     'email'    => env('BSAPI_EMAIL'),  
    //     'api_key'  => env('BSAPI_API_KEY'),  
    //     'password' => env('BSAPI_PASSWORD'), 
    // ];

    // $loginResponse = Http::withOptions(['verify' => false])->post($loginUrl, $credentials);

    // if (!$loginResponse->successful()) {
    //     return redirect()->back()->with('error', 'Login failed! Please check your credentials.');
    // }

    // $token = $loginResponse->json()['token'] ?? null;
    // if (!$token) {
    //     return redirect()->back()->with('error', 'Failed to retrieve authentication token.');
    // }

    // // Step 2: Fetch Students using the endpoint from your environment file
    // $studentUrl = env('BSAPI_STUDENT_ALL_URL'); 
    // $response = Http::withOptions(['verify' => false])
    //                 ->withHeaders([
    //                     'Authorization' => 'Bearer ' . $token,
    //                     'Accept'        => 'application/json',
    //                 ])
    //                 ->get($studentUrl);

    // if (!$response->successful()) {
    //     return redirect()->back()->with('error', 'Failed to fetch student data.');
    // }

    // $students = $response->json();
    // if (empty($students) || !is_array($students)) {
    //     return redirect()->back()->with('error', 'Unexpected API response format.');
    // }

    // // Prepare Bulk Insert Data
    // $insertData = [];
    // foreach ($students as $student) {
    //     $existingStudent = User::where('school_id', $student['regno'])->first();
    //     $imageUrl = !empty($student['image'])
    //         ? $student['image']
    //         : "https://cdn.ucc.edu.gh/photos/?tag=" . ($student['regno'] ?? '');

    //     if (!$existingStudent) {
    //         $insertData[] = [
    //             'firstName'  => $student['fname'],
    //             'middleName' => $student['mname'] ?? null,
    //             'lastName'   => $student['lname'],
    //             'school_id'  => $student['regno'],
    //             'programs'   => $student['dept_name'],
    //             'hall'       => $student['hallid'],
    //             'image'      => $imageUrl,
    //             'gender'     => $student['sex'],
    //             'email'      => $student['email'] ?? $student['inst_email'] ?? null,
    //             'action'     => 'unverified',
    //             'password'   => bcrypt('1234'),
    //             'DOB'        => $student['dob'],
    //             'phone'      => $student['cellphone'] ?? null,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }
    
    // }

    // // Bulk Insert (Avoids Multiple Queries)
    // if (!empty($insertData)) {
    //     User::insert($insertData);
    // }

    // return redirect()->back()->with('success', 'Students fetched and updated successfully!');
}

public function fetchStaff(Request $request)
{
    // Uncomment the following lines if you want to process asynchronously:
    FetchStaffsJob::dispatch();
    return redirect()->back()->with('success', 'Student data is being processed in the background!');

    // Synchronous processing:
    // Step 1: Get Token from API using environment variables
    // $loginUrl = env('BSAPI_LOGIN_URL');
    // $credentials = [
    //     'email'    => env('BSAPI_EMAIL'),  
    //     'api_key'  => env('BSAPI_API_KEY'),  
    //     'password' => env('BSAPI_PASSWORD'), 
    // ];

    // $loginResponse = Http::withOptions(['verify' => false])->post($loginUrl, $credentials);

    // if (!$loginResponse->successful()) {
    //     return redirect()->back()->with('error', 'Login failed! Please check your credentials.');
    // }

    // $token = $loginResponse->json()['token'] ?? null;
    // if (!$token) {
    //     return redirect()->back()->with('error', 'Failed to retrieve authentication token.');
    // }

    // // Step 2: Fetch Students using the endpoint from your environment file
    // $studentUrl = env('BSAPI_STUDENT_ALL_URL'); 
    // $response = Http::withOptions(['verify' => false])
    //                 ->withHeaders([
    //                     'Authorization' => 'Bearer ' . $token,
    //                     'Accept'        => 'application/json',
    //                 ])
    //                 ->get($studentUrl);

    // if (!$response->successful()) {
    //     return redirect()->back()->with('error', 'Failed to fetch student data.');
    // }

    // $students = $response->json();
    // if (empty($students) || !is_array($students)) {
    //     return redirect()->back()->with('error', 'Unexpected API response format.');
    // }

    // // Prepare Bulk Insert Data
    // $insertData = [];
    // foreach ($students as $student) {
    //     $existingStudent = User::where('school_id', $student['regno'])->first();
    //     $imageUrl = !empty($student['image'])
    //         ? $student['image']
    //         : "https://cdn.ucc.edu.gh/photos/?tag=" . ($student['regno'] ?? '');

    //     if (!$existingStudent) {
    //         $insertData[] = [
    //             'firstName'  => $student['fname'],
    //             'middleName' => $student['mname'] ?? null,
    //             'lastName'   => $student['lname'],
    //             'school_id'  => $student['regno'],
    //             'programs'   => $student['dept_name'],
    //             'hall'       => $student['hallid'],
    //             'image'      => $imageUrl,
    //             'gender'     => $student['sex'],
    //             'email'      => $student['email'] ?? $student['inst_email'] ?? null,
    //             'action'     => 'unverified',
    //             'password'   => bcrypt('1234'),
    //             'DOB'        => $student['dob'],
    //             'phone'      => $student['cellphone'] ?? null,
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ];
    //     }
    
    // }

    // // Bulk Insert (Avoids Multiple Queries)
    // if (!empty($insertData)) {
    //     User::insert($insertData);
    // }

    // return redirect()->back()->with('success', 'Students fetched and updated successfully!');
}


    
}
