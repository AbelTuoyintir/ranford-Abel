<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Crypt, Hash, URL};
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\{Nominee, Ticket, documents, supporters};
use Psy\Sudo;

class TicketController extends Controller
{
    //

    public function index()
    {
        return view('livewire.admin.voucher-generator');
    }

    public function vouchers()
    {
        $tickets = Ticket::orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'total' => Ticket::count(),
            'expired' => Ticket::where('expire_at', '<', now())->count(),
            'active' => Ticket::where('expire_at', '>=', now())->orWhereNull('expire_at')->count(),
        ];
        
        return view('livewire.admin.vouchers', compact('tickets', 'stats'));
    }
    
    public function show(Ticket $ticket)
    {
        $nominee = Nominee::where('reg_number', $ticket->school_id)->first();
        // dd($nominee);

        return view('livewire.admin.voucherShow', compact('ticket', 'nominee'));
    }

 
    
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets')->with('success', 'Ticket deleted successfully');
    }
    
    // public function export()
    // {
    //     $tickets = Ticket::all();
    //     // Add CSV export logic here
    // }

    
    public function ManageNorminees()
    {
        // Assuming the admin is authenticated and has a 'hall' attribute
        $admin = Auth::user();
        $adminHall = $admin->hall ?? "";
        
        // Fetch nominees with the same hall as the admin
        if($adminHall == "") {
        $positions = [
            'SRC President',
            'SRC Secretary',
            'SRC Treasurer',
            'SRC General Sports Secretary',
            'SRC Coordinating Secretary',
            'SRC Public Relations Officer',
            'Local NUGS President',
            'Local NUGS Secretary',
            "SRC Women's Commissioner"
        ];

        $nominees = Nominee::with(['supporters', 'runningMate'])
            ->whereIn('position', $positions)
            ->get();
        // dd($nominees);
        }else{
            $positions = [
                'SRC President',
                'SRC Secretary',
                'SRC Treasurer',
                'SRC General Sports Secretary',
                'SRC Coordinating Secretary',
                'SRC Public Relations Officer',
                'Local NUGS President',
                'Local NUGS Secretary',
                "SRC Women's Commissioner"
            ];

            $nominees = Nominee::with(['supporters', 'runningMate'])
                ->where('hall', $adminHall)
                ->whereNotIn('position', $positions)
                ->get();
        }
        

        return view('livewire.admin.current-nominees', compact('nominees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'school_id' => 'required|string|max:100',
        ]);

        do {
            $voucherCode = 'UCC-EVOTE-' . Str::upper(Str::random(5));
        } while (Ticket::where('Voucher', $voucherCode)->exists());

        $plainPassword = Str::random(10);

        $ticket = Ticket::create([
            'Voucher' => $voucherCode,
            'name' => $validated['name'],
            'team' => $validated['team'],
            'school_id' => $validated['school_id'],
            // keep bcrypt hash for login
            'Password' => bcrypt($plainPassword),
            // store reversible encrypted plaintext for admin display
           
            'expire_at' => now()->addDays(5),
        ]);



        return response()->json([
            'success' => true,
            'message' => 'Voucher created successfully!',
            'data' => [
                'name' => $validated['name'],
                'team' => $validated['team'],
                'school_id' => $validated['school_id'],
                'voucher_code' => $voucherCode,
                'password' => $plainPassword,
                'expires_at' => $ticket->expire_at,
            ],
        ], 201);
    }


public function NorminationForm_Print(Request $request)
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
    // if (Carbon::now()->greaterThan($ticket->expire_at)) {
        // return redirect()->back()->with('error', 'Voucher has expired');
    // }

    // Compare password 4bDRaTs5RP
    if (Hash::check($validated['Password'], $ticket->Password)) {
        Auth::guard('ticket')->login($ticket); // Log in the user
        
        // $user=Nominee::where('reg_number',$ticket->school_id)->first();
        $user = Nominee::where('reg_number', $ticket->school_id)
        ->with('supporters')->first();
        if (!$user) {
            return redirect('nomination-forms')->with('success', 'Login successful');
        }

        $supporters = supporters::where('nominee_id', $user->id)->get();
        // ->first();
        // dd($supporters);
        // dd($user);
        if ($user) {
            $userDocuments=documents::where('nominee_id',$user->id)->first();
            if ($user->role === 'aspirant' || in_array($user->status, ['saved', 'submitted'], true)) {
                // Pass the entire user object to the view
                // if($userDocuments){
                    // return redirect('normination-print')->with(
                    //     'success' ,'Congratulations, Please Print Your Forms');
                        // return redirect('normination-print')->with([
                        //     'success' => 'Congratulations, Please Print Your Forms',
                        //     'user' => $user,
                        //     'supporters' => $supporters,
                        // ]);
        return view('livewire.nominee-forms.nomination-print', compact('user', 'supporters'));

                // }
                // return redirect('documents-uploads')->with([
                //     'success' => 'Congratulations, please fill this forms'
                // ]);
            }
            // else{
            //     return redirect('normination-landing-page')->with(
            //         'error' ,'You have already submitted your nomination form');
            // }
        }
        // else{
        //     return redirect('nomination-forms')->with('success', 'Login successful');
        // }

        // return redirect(URL::obfuscated('/display/voting-card')); 
        
        
        //
    }

    return redirect()->back()->with('error', 'Invalid credentials');
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
        Auth::guard('ticket')->login($ticket);

        $user = Nominee::where('reg_number', $ticket->school_id)->first();

        if (!$user) {
            return redirect('nomination-forms')->with('success', 'Login successful. Start your nomination.');
        }

        if (in_array($user->status, ['submitted', 'approved', 'rejected'], true)) {
            return redirect('normination-landing-page')->with(
                'error',
                'This nomination is already submitted and cannot be edited.'
            );
        }

        if ($user->status === 'saved') {
            return redirect('documents-uploads')->with('success', 'Continue by uploading your supporting documents.');
        }

        return redirect('nomination-forms')->with('success', 'Continue your saved draft.');

        // return redirect(URL::obfuscated('/display/voting-card')); 
        
        
        //
    }

    return redirect()->back()->with('error', 'Invalid credentials');
}

    
}
