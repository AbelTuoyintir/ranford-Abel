<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\poll;
use App\Models\User;
use App\Models\Candidate;
use App\Models\portfolios;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class ManageMemberController extends Controller
{
    //
    function manageMembers(){
        
        $moderator =User::whereIn('role',['moderator','verification_officer','super_moderator'])->get();
        
        $candidate= Candidate::get();

        $all_polls = Poll::get();

        $portfolios=portfolios::get();
        // dd($all_polls);
        return view('livewire.admin.manage-members',['moderator'=>$moderator,'candidate'=>$candidate,'all_polls'=>$all_polls,'portfolios'=>$portfolios]);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $user = Auth::user();
        $moderator = User::findOrFail($id);;
        //  dd($moderator);
        if ($moderator) {

        
            // Update the moderator
            $moderator->update([
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'school_id' => $request->school_id,
                'hall' => $request->hall,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            

            return redirect()->back()->with('success' , 'Moderator updated successfully');
        
    }
}

 // Delete a moderator
 public function destroy($id)
 {
     $user = Auth::user();
     $moderator = user::findOrFail($id);

     if ($moderator) {
         

         // Delete the moderator
         $moderator->delete();

         return redirect()->back()->with('success', 'Moderator deleted successfully');
     } 
 }

    public function AddModerator(Request $request)
{
    
    // dd($request);
    // Validate the request
    $validated =  $request->validate([ 
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'school_id' => 'required|string|max:255',
        'programs' => 'required|string|max:255',
        'phone' => 'required',
        'image' => 'required',
        'email' => 'required',
        'bio' => 'nullable|string',
        'gender' => 'required|in:male,female',
        'role'=>'nullable',
        'hall' => 'nullable|string|max:255',
    ]);
    // dd($request);

    $currentYear = now()->year;
    $folderName = 'moderator' . '_' . $currentYear;

    // $validated['role']='moderator';

    // Handle file upload
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store($folderName, 'public');
    }

    
    $user = Auth::user();
    $this->logUserActivity($user, ' Moderator Privilege', 'User added moderator ' . $request->school_id . ' successfully!');
    // Save to database
    User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'school_id' => $request->school_id,
        'programs' => $request->programs,
        'phone' => $request->phone,
        'image' => $validated['image'],
        'email' => $request->email,
        'bio' => $request->bio,
        'gender' => $request->gender,
        'hall' => $request->hall,
        'role' => $request->role,
        'password' => bcrypt('1234'),
    ]);
    
    return redirect()->back()->with('success', 'Moderator added successfully!');
}

public function searchUser(Request $request)
{
    try {
        $searchValue = $request->input('search_value');
        
        // Validate input
        if (empty($searchValue)) {
            return response()->json([]);
        }
        
        // Fetch users from the database with exact match
        $users = User::where('school_id', $searchValue)
            ->get()
            ->map(function($user) {
                // Fetch CGPA from the API for each user
                Log::error($user);  
                $cgpa = $this->fetchCgpaFromApi($user->school_id);
               
                return [
                    'firstName' => $user->firstName ?? '',
                    'middleName' => $user->middleName ?? '',
                    'lastName' => $user->lastName ?? '',
                    'schoolId' => $user->school_id ?? '',
                    'cgpa' => $cgpa, // Use the fetched CGPA
                    'hall' => $user->hall ?? '',
                    'ghanaCardId' => $user->ghana_card_id ?? '',
                    'image' => $user->image ?? '',
                    'biography' => $user->biography ?? ''
                ];
            });
        
        // Return the users with CGPA as JSON
        return response()->json($users);
    } catch (\Exception $e) {
        Log::error('User search error: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while searching'], 500);
    }
}

    /**
     * Fetch CGPA from the API for a given school ID.
     */
    private function fetchCgpaFromApi($schoolId)
{
    $loginUrl = env('BSAPI_LOGIN_URL');
    $studentCgpaUrl = env('BSAPI_STUDENT_CGPA_URL');

    // Step 1: Login to get Bearer Token using credentials from the .env file
    $credentials = [
        'email'    => env('BSAPI_EMAIL'),
        'api_key'  => env('BSAPI_API_KEY'),
        'password' => env('BSAPI_PASSWORD'),
    ];
    
    $loginResponse = Http::withOptions(['verify' => false])->post($loginUrl, $credentials);
    
    if (!$loginResponse->successful()) {
        Log::error('Login failed: ' . $loginResponse->body());
        return null;
    }

    $token = $loginResponse->json()['token'] ?? null;
    
    if (!$token) {
        Log::error('No token received from API.');
        return null;
    }

    // Step 2: Fetch CGPA using the Bearer Token
    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ])
        ->post($studentCgpaUrl, [
            'index_no' => $schoolId,
        ]);

    if (!$response->successful()) {
        Log::error('Error fetching CGPA: ' . $response->body());
        return null;
    }

    $responseData = $response->json();
    if (isset($responseData[0]['CGPA'])) {
        return $responseData[0]['CGPA'];
    } else {
        Log::error('CGPA data not found in API response.');
        return null;
    }
}


function AddVerificationOfficer (Request $request){       
    // Validate the request
    $validated =  $request->validate([ 
        'firstName' => 'required|string|max:255',
        'lastName' => 'required|string|max:255',
        'school_id' => 'required|string|max:255',
        'programs' => 'required|string|max:255',
        'phone' => 'required',
        'image' => 'required',
        'email' => 'required',
        'bio' => 'nullable|string',
        'gender' => 'required|in:male,female',
        'hall' => 'required|string|max:255',
    ]);

    $currentYear = now()->year;
    $folderName = 'verification_officer' . '_' . $currentYear;

    $validated['role']='verification_officer';

    // Handle file upload
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store($folderName, 'public');
    }

    
    $user = Auth::user();
    $this->logUserActivity($user, 'Verification Officer Privillege', 'User added verfication officer ' . $request->school_id . ' successfully!');
    // Save to database
    User::create([
        'firstName' => $request->firstName,
        'lastName' => $request->lastName,
        'school_id' => $request->school_id,
        'programs' => $request->programs,
        'phone' => $request->phone,
        'image' => $validated['image'],
        'email' => $request->email,
        'bio' => $request->bio,
        'gender' => $request->gender,
        'hall' => $request->hall,
        'role' => 'verification_officer',
        'password' => bcrypt('1234')   
     ]);

    return redirect()->back()->with('success', 'verification officer added successfully!');

} 

public function AddCandidate(Request $request)
{
   
    // Validate the incoming request
    $request->validate([
        'candidates.*.first_name' => 'required|string|max:255',
        'candidates.*.middle_name' => 'nullable|string|max:255',
        'candidates.*.last_name' => 'required|string|max:255',
        'candidates.*.ballot_number' => 'required|unique:candidates,ballot_number',
        'candidates.*.teaser' => 'required|string|max:255',
        'candidates.*.team_name' => 'required|string|max:255',
        'candidates.*.cgpa' => 'required',
        'candidates.*.biography' => 'required|string',
        'poll_id' => 'required',

        'candidates.*.ghana_card_id' => 'required',  
        'candidates.*.image_path' => 'required|image|mimes:jpeg,png,jpg',
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
