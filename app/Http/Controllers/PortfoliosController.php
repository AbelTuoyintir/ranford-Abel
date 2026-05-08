<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Poll;
use App\Models\PollSettings;
use App\Models\Portfolios;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class PortfoliosController extends Controller
{
    //
    
   

    public function PopulatePortfoliosCandidate (Request $request){
        $pollId = $request->input('poll_id'); // Get poll_id from the request

    // Assuming you have a relationship between Portfolio and Poll
    $portfolios = json_decode(PollSettings::where('poll_id', $pollId)->pluck('all_portfolios')->first(), true);
 // Filter by poll_id

    return response()->json($portfolios); 
    }



    public function PollSubmitPortfolios(Request $request){
        // Validate input
        $user = Auth::user();
        $validated = $request->validate([
            'portfolios' => 'required|array', // Ensure portfolios is an array
            'portfolios.*' => 'string', // Each portfolio should be a string
            'poll_id' => 'nullable|string'
        ]);
    
        $pollId = $request->input('poll_id');
        $selectedPortfolios = $request->input('portfolios');
    
        // Get the poll type
        $querystring = Poll::where('id', $pollId)->value('poll_type');
    
        // Check if the portfolios already exist for the given poll_id
        $existPortfolios = PollSettings::where('poll_id', $pollId)->first();
    
        if ($existPortfolios) {
            // Update existing record
            $existPortfolios->update([
                'all_portfolios' => json_encode($selectedPortfolios), // Save as JSON array
                'querystring' => $querystring,
                'updated_at' => now(),
            ]);
            
            $this->logUserActivity($user, 'Portfolios',$user->firstName . ' ' . $user->lastName . 'portfolio updated  successfully!');
            return back()->with('success', 'Portfolios already exist.');
        } else {
            // Create a new record if not exists
            PollSettings::create([
                'poll_id' => $pollId,
                'all_portfolios' => json_encode($selectedPortfolios), // Save as JSON array
                'querystring' => $querystring,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->logUserActivity($user, 'Portfolios',$user->firstName . ' ' . $user->lastName .'portfolio submitted  successfully!');
            return back()->with('success', 'Portfolios submitted successfully.');
        }
    }
    
    
    
    public function getPortfolios(Request $request)
    {
        // Get the 'poll_type' parameter from the query string
        $pollType = $request->query('poll_type');

        // Fetch portfolios based on the poll_type
        // Assuming there's a `poll_type` column in your portfolios table
        $portfolios = Portfolios::where('type', $pollType)->get();

        // Return the portfolios as a JSON response
        return response()->json([
            'portfolios' => $portfolios
        ]);
    }
    
    public function index(Request $request)
{
    $query = Portfolios::query();

    // Search by name, description, and type
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%");
        });
    }

    // Get portfolios with pagination
    $portfolios = $query->paginate(4);

    return view('livewire.admin.portfolios', compact('portfolios'));
}

    public function create(Request $request){
        $user = Auth::user();
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required',
        ]); 
        if ($validator['type']=='UCC GENERAL VOTING'){
            $portfolioName = strtoupper('SRC' . ' ' .  $validator['name']);
        }
        else{
            $portfolioName = strtoupper( $validator['type'] . ' ' .  $validator['name']);
        }
        
        try {
            Portfolios::create([
                'name' => $portfolioName, // Use the combined name
                'description' => $validator['description'],
                'type' => $validator['type'],
            ]);
    
            // Redirect back with a success message
            $this->logUserActivity($user, 'Portfolios',$portfolioName.'portfolio created  successfully!');
            return redirect()->back()->with('success', 'Portfolio created successfully!');
            
        } catch (\Exception $e) {
            // Handle the error and redirect with a failure message
            $this->logUserActivity($user, 'Portfolios',$portfolioName. 'portfolio   unsuccessfully!');
            return redirect()->back()->with('error', 'An error occurred while creating the portfolio.');
        }

    }

    public function edit($id)
    {
        $user = Auth::user();
        // Find portfolio by ID
        $portfolio = Portfolios::findOrFail($id);
        $this->logUserActivity($user, 'Portfolios',$portfolio->name. 'portfolio deleted successfully!');
        return view('livewire.admin.edit-portfolio', compact('portfolio'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required',
        ]);

        try {
            // Find and update portfolio
            $portfolio = Portfolios::findOrFail($id);
            $portfolio->update($validated);
            $this->logUserActivity($user, 'Portfolios',$portfolio->name. 'portfolio updated  successfully!');
            return redirect()->back()->with('success', 'Portfolio updated successfully!');
        } catch (\Exception $e) {
            $this->logUserActivity($user, 'Portfolios',$user. 'portfolio   unsuccessfully!');
            return redirect()->back()->with('error', 'An error occurred while updating the portfolio.');
        }

        
    }
    public function destroy($id)
    {
        $user = Auth::user();
        try {
            // Find and delete portfolio
            $portfolio = Portfolios::findOrFail($id);
            $portfolio->delete();
            $this->logUserActivity($user, 'Portfolios',$user.'portfolio deleted successfully!');   
            return redirect()->back()->with('success', 'Portfolio deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the portfolio.');
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
