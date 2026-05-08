<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Nominee;
use App\Models\documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TicketController extends Controller
{
    //
    public function index()
    {
        return view('livewire.admin.voucher-generator');
    }
    
    public function ManageNorminees(){
        $admin = Auth::user();
        $adminHall = $admin->hall ?? null; // Get the hall of the admin, or null if not set

        $nominees = Nominee::with(['supporters', 'runningMate'])
        ->where('hall', $adminHall) // Filter nominees by the admin's hall
        ->get();
        // dd($nominees);    
        return view('livewire.admin.current-nominees',compact('nominees'));
    }

    public function store(Request $request)
 {  
    $validated = $request->validate([
        'Voucher' => 'required|string|unique:tickets,Voucher',
        'Password' => 'required|string',
        'school_id'=> 'required|string',
    ]);
    $voucher = Ticket::create([
        'Voucher' => $validated['Voucher'],
        'school_id' => $validated['school_id'],
        'Password' => bcrypt($validated['Password']),
        // 'created_by' => auth()->id()
        'expire_at' => now()->addDays(5), // Set expiration date to 30 days from now
    ]);
    return redirect()->back()
            ->with('success', 'Voucher created successfully!');
   

}


public function NorminationLogin(Request $request)
{
    $validated = $request->validate([
        'Voucher' => 'required|string',
        'Password' => 'required|string'
    ]);

    // Retrieve the ticket using the Voucher
    $ticket = Ticket::where('Voucher', $validated['Voucher'])->first();

    // Check if ticket exists
    if (!$ticket) {
        return redirect()->back()->with('error', 'Invalid Voucher');
    }

    // Check if the Voucher is expired
    if (Carbon::now()->greaterThan($ticket->expire_at)) {
        return redirect()->back()->with('error', 'Voucher has expired');
    }

    // Compare password 4bDRaTs5RP
    if (Hash::check($validated['Password'], $ticket->Password)) {
        Auth::guard('ticket')->login($ticket); // Log in the user
        
        
        $user=Nominee::where('reg_number',$ticket->school_id)->first();
       
        if ($user) {
            $userDocuments=documents::where('nominee_id',$user->id)->first();
            if ($user->role === 'aspirant' && $user->status === 'submitted' ) {
                // Pass the entire user object to the view
                if($userDocuments){
                    return redirect('normination-landing-page')->with(
                        'error' ,'You have already submitted your nomination form');
                }
                return redirect('documents-uploads')->with([
                    'success' => 'Congratulations, please fill this forms'
                ]);
            }
            else{
                return redirect('normination-landing-page')->with(
                    'error' ,'You have already submitted your nomination form');
            }
        }
        else{
            return redirect('nomination-forms')->with('success', 'Login successful');
        }

        // return redirect(URL::obfuscated('/display/voting-card')); 
        
        
        //
    }

    return redirect()->back()->with('error', 'Invalid credentials');
}

    
}
