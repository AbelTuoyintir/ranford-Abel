<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Hash, Http, Log, Mail};
use Exception;

use App\Models\{Nominee, Ticket, documents, running_mates, supporters};

class NominationController extends Controller
{
   
    public function searchNominee(Request $request)
{
    try {
        $searchValue = $request->input('search_value');
        
        // Validate input
        if (empty($searchValue)) {
            return response()->json([
                'success' => false,
                'message' => 'Search value cannot be empty'
            ], 400);
        }
        // Step 1: Get API credentials and URLs from .env
        $loginUrl = env('BSAPI_LOGIN_URL');
        $studentUrl = env('BSAPI_STUDENT_URL');
        $cgpaUrl = env('BSAPI_STUDENT_CGPA_URL');

        $credentials = [
            'email'    => env('BSAPI_EMAIL'),
            'api_key'  => env('BSAPI_API_KEY'),
            'password' => env('BSAPI_PASSWORD'),
        ];
       
        // Step 2: Login to get Bearer Token
        $loginResponse = Http::withOptions(['verify' => false])->post($loginUrl, $credentials);

        if (!$loginResponse->successful()) {
            return response()->json([
                'error'  => 'Login failed. Check API credentials.',
                'status' => $loginResponse->status(),
                'body'   => $loginResponse->body(),
            ], 401);
        }

        $token = $loginResponse->json()['token'] ?? null;
    if (!$token) {
        return response()->json(['error' => 'Invalid API response. No token received.'], 400);
    }

        // Step 3: Fetch student data with exact match
        $studentResponse = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])
            ->post($studentUrl, [
                'index_no' => $searchValue,
                'exact_match' => true // Ensure API does exact matching
            ]);

        if (!$studentResponse->successful()) {
            return response()->json([
                'success' => false,
                'error'  => 'Error fetching student data',
                'status' => $studentResponse->status(),
            ], $studentResponse->status());
        }

        $studentData = $studentResponse->json();
        
        if (empty($studentData)) {
            return response()->json([
                'success' => false,
                'message' => 'No student found with this exact ID'
            ], 404);
        }

        $student = $studentData[0];

        // Verify the ID matches exactly (case-sensitive)
        if ($student['regno'] !== $searchValue) {
            return response()->json([
                'success' => false,
                'message' => 'No exact match found'
            ], 404);
        }

        // Step 4: Fetch CGPA only for exact match
          $cgpa = $cgpaData['cgpa'] ?? null;
          $cgpa = $this->fetchCgpaFromApi($searchValue);

        // Format response
        return response()->json([
            [
                'firstName' => $student['fname'] ?? '',
                'lastName' => $student['lname'] ?? '',
                'schoolId' => $student['regno'],
                'hall' => $student['hallid'] ?? '',
                'email'      => $student['inst_email'] ?? $student['email'] ?? null,
                'program' => $student['program_name'] ?? '',
                'department' => $student['dept_name'] ?? 'N/A',
                'cgpa' => $cgpa,
                'phone' => $student['cellphone'] ?? '',
                'image' => $student['image'] ?? "https://cdn.ucc.edu.gh/photos/?tag=".$student['regno']
            ]
        ]);
        
    } catch (\Exception $e) {
        Log::error('Nominee search error: '.$e->getMessage()."\n".$e->getTraceAsString());
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while searching',
            'error' => $e->getMessage()
        ], 500);
    }
    }


    public function promote(Nominee $nominee, Request $request)
    {
        //dd($request->role);
        $nominee->update(['role' => $request->role]);
        return back()->with('success', 'Nominee promoted successfully');
    }

    public function disqualify(Request $request, Nominee $nominee)
{
    
    //dd($request->all());
    $validated = $request->validate([
        'rejection_reason' => 'required|string|max:255'
    ]);
    
    $nominee->update([
        'status' => 'rejected',
        'rejection_reason' => $validated['rejection_reason']
    ]);
    
    return back()->with('success', 'Nominee disqualified');
}

 public function requalify(Request $request, Nominee $nominee)
{
    
    //dd($request->all());
    $validated = $request->validate([
        'status' => 'required|string|max:255'
    ]);
    
    $nominee->update([
        'status' => $validated['status'],
    ]);
    
    return back()->with('success', 'Nominee requalified');
}

    public function show(Nominee $nominee)
    {
       //dd($nominee->documents);
        return view('livewire.admin.show-nominees', compact('nominee'));
    }

    public function updatePortfolio(Request $request, $id)
    {
        
        $nominee = Nominee::findOrFail($id);
        
        $validated = $request->validate([
            'position' => 'required|string|max:5000',
        ]);
        
        $nominee->position = $validated['position'];
        $nominee->save();

        return back()->with('success', 'Portfolio updated successfully.');
    
    }

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
    // // Show all nominees
    public function index()
    {
        $nominees = Nominee::all();
        $ticketUser = Auth::guard('ticket')->user();
        $draftNominee = null;

        if ($ticketUser) {
            $draftNominee = Nominee::with(['runningMate', 'supporters'])
                ->where('reg_number', $ticketUser->school_id)
                ->first();

            if ($draftNominee && in_array($draftNominee->status, ['submitted', 'approved', 'rejected'], true)) {
                return redirect('normination-landing-page')
                    ->with('error', 'Your nomination has already been submitted and cannot be edited.');
            }
        }

        return view('livewire.nominee-forms.nomination-form', [
            'nominees' => $nominees,
            'draftNominee' => $draftNominee,
        ]);
    }

    public function nominationLandingPage(){

        return view('livewire.admin.normination-landing-page');
    }

    public function nominationPrintPage(){

        return view('livewire.nominee-forms.nomination-print');
    }

   public function Documents()
{
    $userTicket = Auth::guard('ticket')->user();
    if (!$userTicket) {
        return redirect()->route('nomination.login')->with('error', 'Please log in to access this page.');
    }
    
    $user = Nominee::where('reg_number', $userTicket->school_id)->first();

    if (!$user) {
        return redirect('nomination-forms')->with('error', 'Please complete your nomination form first.');
    }

    if (in_array($user->status, ['submitted', 'approved', 'rejected'], true)) {
        return redirect('nomination-landing-page')->with('error', 'Your submission is locked and cannot be edited.');
    }

    // Get existing documents - this will be passed to the view
    $existingDocs = documents::where('nominee_id', $user->id)->get()->keyBy('type');

    return view('livewire.nominee-forms.documents-uploads', [
        'user' => $user,
        'existingDocs' => $existingDocs,  // Pass to view for display
    ]);
}

public function storeDocuments(Request $request, Nominee $user)
{
    // 🔍 First, log what we received (remove after testing)
    \Log::info('storeDocuments called with action: ' . $request->input('action'));
    \Log::info('All request data: ' . json_encode($request->except('_token')));
    
    $action = $request->input('action', 'save');
    $isSubmit = ($action === 'submit');
    $isDraft = ($action === 'save');
    
    // 🔍 Debug output (remove after testing)
    \Log::info("Action: $action, isSubmit: " . ($isSubmit ? 'true' : 'false') . ", isDraft: " . ($isDraft ? 'true' : 'false'));

    $ticketUser = Auth::guard('ticket')->user();

    if (!$ticketUser || strtoupper($ticketUser->school_id) !== strtoupper($user->reg_number)) {
        return back()->with('error', 'Unauthorized document action.');
    }

    // Prevent edits if already submitted/approved/rejected
    if (in_array($user->status, ['submitted', 'approved', 'rejected'], true)) {
        return back()->with('error', 'Your submission is locked and can no longer be edited.');
    }

    $validated = $request->validate([
        'cgpa_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'fee_receipt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        'medical_report' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'passport_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    try {
        DB::beginTransaction();

        $documentTypes = [
            'cgpa_file' => 'cgpa',
            'fee_receipt' => 'fee_receipt',
            'cv_file' => 'cv',
            'medical_report' => 'medical_report',
            'passport_photo' => 'passport_photo'
        ];

        $uploadedCount = 0;
        $updatedDocuments = [];

        foreach ($documentTypes as $field => $type) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                $oldDoc = documents::where('nominee_id', $user->id)
                    ->where('type', $type)
                    ->first();
                
                if ($oldDoc && $oldDoc->path) {
                    \Storage::disk('public')->delete($oldDoc->path);
                }
                
                // Store new file
                $path = $request->file($field)->store(
                    "documents/{$user->id}",
                    'public'
                );

                documents::updateOrCreate(
                    [
                        'nominee_id' => $user->id,
                        'type' => $type,
                    ],
                    [
                        'path' => $path,
                        'verified' => false,
                    ]
                );
                $uploadedCount++;
                $updatedDocuments[] = $type;
            }
        }

        // Get existing documents count
        $existingDocsCount = documents::where('nominee_id', $user->id)->count();
        $requiredCount = count($documentTypes);

        // ✅ CRITICAL FIX: Handle SUBMIT action FIRST
        if ($isSubmit === true) {
            \Log::info('🔴 PROCESSING SUBMIT - Updating status to submitted');
            
            // Check if ALL required documents exist
            $existingTypes = documents::where('nominee_id', $user->id)->pluck('type')->toArray();
            $requiredTypes = array_values($documentTypes);
            $missing = array_values(array_diff($requiredTypes, $existingTypes));

            if (!empty($missing)) {
                DB::rollBack();
                $missingLabels = array_map(function($type) {
                    return str_replace('_', ' ', ucfirst($type));
                }, $missing);
                return back()->with('error', 'Please upload all required documents before final submission. Missing: ' . implode(', ', $missingLabels));
            }

            // ✅ UPDATE TO SUBMITTED STATUS
            $user->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'medical_clearance' => true,
                'fee_paid' => true,
                'verified' => false,
            ]);
            
            \Log::info('✅ Status updated to: ' . $user->fresh()->status);

            DB::commit();

            return redirect('/normination-landing-page')
                ->with('success', '✅ Documents submitted successfully! Your nomination is now complete. Please wait for admin approval.');
        } 
        
        // ✅ Handle DRAFT action (Save & Continue)
        elseif ($isDraft === true) {
            \Log::info('💾 PROCESSING DRAFT - Updating status to saved');
            
            // Only update status if user hasn't submitted yet
            if ($user->status !== 'submitted') {
                $user->update([
                    'status' => 'saved',
                    'verified' => false,
                ]);
            }

            DB::commit();

            // Build appropriate success message
            if ($uploadedCount > 0) {
                $updatedList = implode(', ', array_map(function($type) {
                    return str_replace('_', ' ', ucfirst($type));
                }, $updatedDocuments));
                
                $message = "✅ Documents saved successfully! Updated: $updatedList. ($uploadedCount file(s) uploaded/replaced)";
            } else {
                if ($existingDocsCount > 0) {
                    $message = "📁 Draft saved. You have $existingDocsCount of $requiredCount documents uploaded. Continue adding more documents.";
                } else {
                    $message = "📝 No new files selected. Please choose files to upload before saving.";
                }
            }

            return redirect('/normination-landing-page')->with('success', $message);
        }
        
        // ✅ Fallback for unknown action
        else {
            \Log::warning('⚠️ Unknown action received: ' . $action);
            DB::rollBack();
            return back()->with('error', 'Invalid action. Please use Save or Submit button.');
        }

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Document upload error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return back()->with('error', 'Error submitting documents: ' . $e->getMessage());
    }
}

    public function verify(documents $document)
    {
        $document->update(['verified' => true]);
        return back()->with('success', 'Document verified successfully');
    }

    public function reject(documents $document)
    {
        $document->delete();
        return back()->with('success', 'Document rejected successfully');
    }

    // Show form to create a nominee
    
    

    // Show form to edit a nominee
    public function edit(Nominee $nominee)
    {
        return view('nominees.edit', compact('nominee'));
    }

    public function save(Request $request)
{
    $action = $request->input('action', 'save');
    $isSubmit = $action === 'submit';  // 'submit' = final submission
    $isDraft = $action === 'save';      // 'save' = save as draft

    $ticketUser = Auth::guard('ticket')->user();
    if (!$ticketUser) {
        return redirect('normination-landing-page')->with('error', 'Please log in again to continue.');
    }

    $rules = $this->getNominationValidationRules($isSubmit);
    $validated = $request->validate($rules);

    $ticketRegNumber = strtoupper(trim((string) $ticketUser->school_id));
    $submittedRegNumber = strtoupper(trim((string) ($validated['reg_number'] ?? '')));

    if ($submittedRegNumber !== '' && $submittedRegNumber !== $ticketRegNumber) {
        return back()->withErrors(['reg_number' => 'The registration number must match your voucher account.'])->withInput();
    }

    $regNumber = $submittedRegNumber !== '' ? $submittedRegNumber : $ticketRegNumber;
    $nominee = Nominee::where('reg_number', $regNumber)->first();

    // Check if already submitted/approved/rejected
    if ($nominee && in_array($nominee->status, ['submitted', 'approved', 'rejected'], true)) {
        return redirect('normination-landing-page')->with('error', 'You have already submitted this nomination and it can no longer be edited.');
    }

    // Validation for running mate on final submit only
    if ($isSubmit && $this->requiresRunningMate($validated['position'] ?? null) && empty($validated['running_mates_full_name'])) {
        return back()->withErrors(['running_mates_full_name' => 'Running mate is required for this position.'])->withInput();
    }

    DB::beginTransaction();

    try {
        $nomineePayload = $this->buildNomineePayload($validated, $regNumber, $nominee, $isSubmit);
        
        // ✅ Set status based on button clicked
        if ($isSubmit) {
            $nomineePayload['status'] = 'saved';  // Final submission
            $nomineePayload['role'] = 'nominee'; // Ensure role is set to nominee on final submission
            $nomineePayload['submitted_at'] = now();
        } else {
            $nomineePayload['status'] = 'draft';      // Save as draft
        }

        if ($nominee) {
            $nominee->update($nomineePayload);
        } else {
            $nominee = Nominee::create($nomineePayload);
        }

        $this->upsertRunningMate($nominee, $validated);
        $supporters = $this->upsertSupporters($nominee, $validated);

        // Send emails ONLY on final submission
        if ($isSubmit) {
            foreach ($supporters as $supporter) {
                if (!$supporter->email) {
                    continue;
                }

                try {
                    $confirmationUrl = url('/guarantor/confirm/' . $supporter->confirmation_token);
                    $declineUrl = url('/guarantor/decline/' . $supporter->confirmation_token);

                    $emailBody = "
                        Dear {$supporter->name},<br><br>
                        You have been listed as a guarantor for nominee <b>{$nominee->full_name}</b> (Reg No: {$nominee->reg_number}) for the position of <b>{$nominee->position}</b>.<br>
                        Please click the link below to review and confirm or decline your approval:<br><br>
                        <a href=\"{$confirmationUrl}\" style=\"padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;\">Accept</a>
                        &nbsp;&nbsp;
                        <a href=\"{$declineUrl}\" style=\"padding:10px 20px;background:#dc3545;color:#fff;text-decoration:none;border-radius:5px;\">Decline</a>
                        <br><br>
                        If you did not expect this email, you can safely ignore it.
                    ";

                    Mail::send([], [], function ($message) use ($supporter, $emailBody) {
                        $message->to($supporter->email)
                            ->subject('Confirm Your Guarantor Approval')
                            ->html($emailBody);
                    });
                } catch (\Exception $mailEx) {
                    Log::error('Failed to send guarantor confirmation email: ' . $mailEx->getMessage());
                }
            }
        }

        DB::commit();

        if ($isSubmit) {
            return redirect('/normination-landing-page')->with('success', 'Nomination submitted successfully! Please check your email for guarantor confirmation links.');
        }

        return redirect('/normination-landing-page')->with('success', 'Draft saved successfully. You can continue later.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Nomination save error: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        return back()->with('error', 'An error occurred while saving your nomination.');
    }
}

    private function getNominationValidationRules(bool $isSubmit): array
    {
        $cgpaRule = function ($attribute, $value, $fail) {
            if ($value === null || $value === '') {
                return;
            }

            if (!is_numeric($value) || (($value < 2.5 || $value > 4) && $value < 65)) {
                $fail('The CGPA must be between 2.5 and 4.0 or 65 and above.');
            }
        };

        return [
            'position' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'reg_number' => 'nullable|string|max:50',
            'full_name' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'hall' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'program' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'phone' => $isSubmit ? 'required|string' : 'nullable|string',
            'nominee_cgpa' => [$isSubmit ? 'required' : 'nullable', $cgpaRule],
            'verified' => $isSubmit ? 'required|accepted' : 'nullable',

            'running_mates_full_name' => $isSubmit ? 'nullable|string|max:255' : 'nullable|string|max:255',
            'running_mates_cgpa' => ['nullable', $cgpaRule],
            'running_mates_hall' => 'nullable|string|max:255',
            'running_mates_reg_number' => 'nullable|string|max:50',
            'running_mates_program' => 'nullable|string|max:255',
            'running_mates_phone' => 'nullable|string',
            'running_mates_status' => 'nullable',

            'guarantor.1.reg_number' => $isSubmit ? 'required|string|max:50' : 'nullable|string|max:50',
            'guarantor.1.name' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.1.hall' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.1.department' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.1.program' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.1.phone' => $isSubmit ? 'required|string' : 'nullable|string',
            'guarantor.1.date' => $isSubmit ? 'required|date' : 'nullable|date',
            'guarantor.1.verified' => $isSubmit ? 'required|accepted' : 'nullable',
            'guarantor.1.email' => $isSubmit ? 'required|email' : 'nullable|email',

            'guarantor.2.reg_number' => $isSubmit ? 'required|string|max:50' : 'nullable|string|max:50',
            'guarantor.2.name' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.2.hall' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.2.department' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.2.program' => $isSubmit ? 'required|string|max:255' : 'nullable|string|max:255',
            'guarantor.2.phone' => $isSubmit ? 'required|string' : 'nullable|string',
            'guarantor.2.date' => $isSubmit ? 'required|date' : 'nullable|date',
            'guarantor.2.verified' => $isSubmit ? 'required|accepted' : 'nullable',
            'guarantor.2.email' => $isSubmit ? 'required|email' : 'nullable|email',
        ];
    }

    private function requiresRunningMate(?string $position): bool
    {
        return in_array($position, ['SRC President', 'JCRC President', 'GRASAG President'], true);
    }

    private function buildNomineePayload(array $validated, string $regNumber, ?Nominee $existing, bool $isSubmit): array
    {
        $fullName = $validated['full_name'] ?? ($existing->full_name ?? '');
        $position = $validated['position'] ?? ($existing->position ?? '');
        $hall = $validated['hall'] ?? ($existing->hall ?? '');
        $program = $validated['program'] ?? ($existing->program ?? '');
        $phone = $validated['phone'] ?? ($existing->phone ?? '');
        $cgpa = $validated['nominee_cgpa'] ?? ($existing->nominee_cgpa ?? 0);

        return [
            'full_name' => $fullName,
            'reg_number' => $regNumber,
            'position' => $position,
            'phone' => $phone,
            'hall' => $hall,
            'program' => $program,
            'photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $regNumber,
            'nominee_cgpa' => $cgpa === '' ? 0 : $cgpa,
            'verified' => $isSubmit ? true : ($existing->verified ?? false),
            'role' => $existing->role ?? 'nominee',
            'status' => $isSubmit ? 'saved' : 'draft',
        ];
    }

    private function upsertRunningMate(Nominee $nominee, array $validated): void
    {
        $runningMateData = [
            'running_mates_full_name' => $validated['running_mates_full_name'] ?? null,
            'running_mates_hall' => $validated['running_mates_hall'] ?? null,
            'running_mates_cgpa' => $validated['running_mates_cgpa'] ?? null,
            'running_mates_reg_number' => $validated['running_mates_reg_number'] ?? null,
            'running_mates_program' => $validated['running_mates_program'] ?? null,
            'running_mates_phone' => $validated['running_mates_phone'] ?? null,
            'running_mates_photo_path' => !empty($validated['running_mates_reg_number'])
                ? 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['running_mates_reg_number']
                : null,
            'running_mates_status' => $validated['running_mates_status'] ?? null,
        ];

        if (!empty($runningMateData['running_mates_full_name'])) {
            running_mates::updateOrCreate(
                ['nominee_id' => $nominee->id],
                $runningMateData
            );
            return;
        }

        running_mates::where('nominee_id', $nominee->id)->delete();
    }

    private function upsertSupporters(Nominee $nominee, array $validated): array
    {
        $supportersPayload = [];
        foreach ([1, 2] as $index) {
            $g = $validated['guarantor'][$index] ?? null;
            if (!$g || empty($g['name']) || empty($g['reg_number'])) {
                continue;
            }

            $supportersPayload[] = [
                'nominee_id' => $nominee->id,
                'reg_number' => $g['reg_number'],
                'name' => $g['name'],
                'hall' => $g['hall'] ?? null,
                'department' => $g['department'] ?? null,
                'program' => $g['program'] ?? null,
                'phone' => $g['phone'] ?? null,
                'date' => $g['date'] ?? null,
                'verified' => false,
                'id_copy_path' => !empty($g['reg_number']) ? 'https://cdn.ucc.edu.gh/photos/?tag=' . $g['reg_number'] : null,
                'email' => $g['email'] ?? null,
                'confirmation_token' => Str::random(40),
            ];
        }

        supporters::where('nominee_id', $nominee->id)->delete();
        $created = [];
        foreach ($supportersPayload as $payload) {
            $created[] = supporters::create($payload);
        }

        return $created;
    }

    public function saveLegacy(Request $request)
    {
        $validated = $request->validate([
            'nominee_cgpa' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) ||
                        (
                            ($value < 2.5 || $value > 4) &&
                            $value < 65
                        )
                    ) {
                        $fail('The CGPA must be between 2.5 and 4.0 or 65 and above.');
                    }
                }
            ],
            'position' => 'required|string|max:255',
            'reg_number' => 'required|string|max:50',
            'full_name' => 'required|string|max:255',
            'hall' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'phone' => 'required|string',
            'verified' => 'required',

            'running_mates_full_name' => 'nullable|string|max:255',
            'running_mates_cgpa' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_numeric($value) ||
                        (
                            ($value < 2.5 || $value > 4) &&
                            $value < 65
                        )
                    ) {
                        $fail('The CGPA must be between 2.5 and 4.0 or 65 and above.');
                    }
                }
            ],
            'running_mates_hall' => 'nullable|string|max:255',
            'running_mates_reg_number' => 'nullable|string|max:50',
            'running_mates_program' => 'nullable|string|max:255',
            'running_mates_phone' => 'nullable|string',
            'running_mates_status' => 'nullable',

            'guarantor.1.reg_number' => 'required|string|max:50',
            'guarantor.1.name' => 'required|string|max:255',
            'guarantor.1.hall' => 'required|string|max:255',
            'guarantor.1.department' => 'required|string|max:255',
            'guarantor.1.program' => 'required|string|max:255',
            'guarantor.1.phone' => 'required|string',
            'guarantor.1.date' => 'required|date',
            'guarantor.1.verified' => 'required|accepted',
            'guarantor.1.email' => 'required|email',

            'guarantor.2.reg_number' => 'required|string|max:50',
            'guarantor.2.name' => 'required|string|max:255',
            'guarantor.2.hall' => 'required|string|max:255',
            'guarantor.2.department' => 'required|string|max:255',
            'guarantor.2.program' => 'required|string|max:255',
            'guarantor.2.phone' => 'required|string',
            'guarantor.2.date' => 'required|date',
            'guarantor.2.verified' => 'required|accepted',
            'guarantor.2.email' => 'required|email',
        ]);
        if (
            $validated['position'] == 'SRC President' ||
            $validated['position'] == 'JCRC President' ||
            $validated['position'] == 'GRASAG President'
        ) {
            
            if ($validated['running_mates_full_name']==null || $validated['running_mates_full_name'] == '') {
            // Instead of redirecting here, throw a validation exception
            return back()->withErrors(['running_mates_full_name' => 'Running mate is required for this position.'])->withInput();
            }
                DB::beginTransaction();

                try {
                    $nominee = Nominee::create([
                        'full_name' => $validated['full_name'],
                        'reg_number' => $validated['reg_number'],
                        'position' => $validated['position'],
                        'phone' => $validated['phone'],
                        'hall' => $validated['hall'],
                        'program' => $validated['program'],
                        'photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['reg_number'],
                        'nominee_cgpa' => $validated['nominee_cgpa'],
                        'verified' => $validated['verified'] === 'on' || $validated['verified'] === '1' || $validated['verified'] === true,
                        'role' => 'nominee',
                        'status' => 'submitted'
                    ]);

                    if (!empty($validated['running_mates_full_name'])) {
                        running_mates::create([
                            'nominee_id' => $nominee->id,
                            'running_mates_full_name' => $validated['running_mates_full_name'],
                            'running_mates_hall' => $validated['running_mates_hall'],
                            'running_mates_cgpa' => $validated['running_mates_cgpa'],
                            'running_mates_reg_number' => $validated['running_mates_reg_number'],
                            'running_mates_program' => $validated['running_mates_program'],
                            'running_mates_phone' => $validated['running_mates_phone'],
                            'running_mates_photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['running_mates_reg_number'],
                            'running_mates_status' => $validated['running_mates_status'] ?? null,
                        ]);
                    }

                    foreach ([1, 2] as $index) {
                        if (isset($validated['guarantor'][$index])) {
                            $guarantorData = $validated['guarantor'][$index];
                            $supporter = supporters::create([
                                'nominee_id' => $nominee->id,
                                'reg_number' => $guarantorData['reg_number'],
                                'name' => $guarantorData['name'],
                                'hall' => $guarantorData['hall'],
                                'department' => $guarantorData['department'],
                                'program' => $guarantorData['program'],
                                'phone' => $guarantorData['phone'],
                                'date' => $guarantorData['date'],
                                'verified' => false,
                                'id_copy_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $guarantorData['reg_number'],
                                'email' => $guarantorData['email'],
                                'confirmation_token' => Str::random(40),
                                'confirmed' => false,
                            ]);

                            try {
                                $confirmationUrl = url('/guarantor/confirm/' . $supporter->confirmation_token);
                                $declineUrl = url('/guarantor/decline/' . $supporter->confirmation_token);

                                $emailBody = "
                                    Dear {$supporter->name},<br><br>
                                    You have been listed as a guarantor for nominee <b>{$nominee->full_name}</b> (Reg No: {$nominee->reg_number}) for the position of <b>{$nominee->position}</b>.<br>
                                    Please click the link below to review and confirm or decline your approval:<br><br>
                                    <a href=\"{$confirmationUrl}\" style=\"padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;\">Accept</a>
                                    &nbsp;&nbsp;
                                    <a href=\"{$declineUrl}\" style=\"padding:10px 20px;background:#dc3545;color:#fff;text-decoration:none;border-radius:5px;\">Decline</a>
                                    <br><br>
                                    If you did not expect this email, you can safely ignore it.
                                ";

                                Mail::send([], [], function ($message) use ($supporter, $emailBody) {
                                    $message->to($supporter->email)
                                        ->subject('Confirm Your Guarantor Approval')
                                        ->html($emailBody);
                                });
                            } catch (\Exception $mailEx) {
                                Log::error('Failed to send guarantor confirmation email: ' . $mailEx->getMessage());
                            }
                        }
                    }

                    DB::commit();
                return redirect('normination-landing-page')->with('success', 'Nomination submitted successfully! Guarantors have been notified by email.');

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Nomination save error: ' . $e->getMessage());
                    Log::error($e->getTraceAsString());
                    return redirect()->back()->with('error', 'An error occurred while saving your nomination.');
                }
        }
        if (
            $validated['position'] == 'SRC President' ||
            $validated['position'] == 'JCRC President' ||
            $validated['position'] == 'GRASAG President'
        ) {
            
            if ($validated['running_mates_full_name']==null || $validated['running_mates_full_name'] == '') {
            // Instead of redirecting here, throw a validation exception
            return back()->withErrors(['running_mates_full_name' => 'Running mate is required for this position.'])->withInput();
            }
                DB::beginTransaction();

                try {
                    $nominee = Nominee::create([
                        'full_name' => $validated['full_name'],
                        'reg_number' => $validated['reg_number'],
                        'position' => $validated['position'],
                        'phone' => $validated['phone'],
                        'hall' => $validated['hall'],
                        'program' => $validated['program'],
                        'photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['reg_number'],
                        'nominee_cgpa' => $validated['nominee_cgpa'],
                        'verified' => $validated['verified'] === 'on' || $validated['verified'] === '1' || $validated['verified'] === true,
                        'role' => 'nominee',
                        'status' => 'submitted'
                    ]);

                    if (!empty($validated['running_mates_full_name'])) {
                        running_mates::create([
                            'nominee_id' => $nominee->id,
                            'running_mates_full_name' => $validated['running_mates_full_name'],
                            'running_mates_hall' => $validated['running_mates_hall'],
                            'running_mates_cgpa' => $validated['running_mates_cgpa'],
                            'running_mates_reg_number' => $validated['running_mates_reg_number'],
                            'running_mates_program' => $validated['running_mates_program'],
                            'running_mates_phone' => $validated['running_mates_phone'],
                            'running_mates_photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['running_mates_reg_number'],
                            'running_mates_status' => $validated['running_mates_status'] ?? null,
                        ]);
                    }

                    foreach ([1, 2] as $index) {
                        if (isset($validated['guarantor'][$index])) {
                            $guarantorData = $validated['guarantor'][$index];
                            $supporter = supporters::create([
                                'nominee_id' => $nominee->id,
                                'reg_number' => $guarantorData['reg_number'],
                                'name' => $guarantorData['name'],
                                'hall' => $guarantorData['hall'],
                                'department' => $guarantorData['department'],
                                'program' => $guarantorData['program'],
                                'phone' => $guarantorData['phone'],
                                'date' => $guarantorData['date'],
                                'verified' => false,
                                'id_copy_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $guarantorData['reg_number'],
                                'email' => $guarantorData['email'],
                                'confirmation_token' => Str::random(40),
                                'confirmed' => false,
                            ]);

                            try {
                                $confirmationUrl = url('/guarantor/confirm/' . $supporter->confirmation_token);
                                $declineUrl = url('/guarantor/decline/' . $supporter->confirmation_token);

                                $emailBody = "
                                    Dear {$supporter->name},<br><br>
                                    You have been listed as a guarantor for nominee <b>{$nominee->full_name}</b> (Reg No: {$nominee->reg_number}) for the position of <b>{$nominee->position}</b>.<br>
                                    Please click the link below to review and confirm or decline your approval:<br><br>
                                    <a href=\"{$confirmationUrl}\" style=\"padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;\">Accept</a>
                                    &nbsp;&nbsp;
                                    <a href=\"{$declineUrl}\" style=\"padding:10px 20px;background:#dc3545;color:#fff;text-decoration:none;border-radius:5px;\">Decline</a>
                                    <br><br>
                                    If you did not expect this email, you can safely ignore it.
                                ";

                                Mail::send([], [], function ($message) use ($supporter, $emailBody) {
                                    $message->to($supporter->email)
                                        ->subject('Confirm Your Guarantor Approval')
                                        ->html($emailBody);
                                });
                            } catch (\Exception $mailEx) {
                                Log::error('Failed to send guarantor confirmation email: ' . $mailEx->getMessage());
                            }
                        }
                    }

                    DB::commit();
                return redirect('normination-landing-page')->with('success', 'Nomination submitted successfully! Guarantors have been notified by email.');

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Nomination save error: ' . $e->getMessage());
                    Log::error($e->getTraceAsString());
                    return redirect()->back()->with('error', 'An error occurred while saving your nomination.');
                }
        }
        DB::beginTransaction();

        try {
            $nominee = Nominee::create([
                'full_name' => $validated['full_name'],
                'reg_number' => $validated['reg_number'],
                'position' => $validated['position'],
                'phone' => $validated['phone'],
                'hall' => $validated['hall'],
                'program' => $validated['program'],
                'photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['reg_number'],
                'nominee_cgpa' => $validated['nominee_cgpa'],
                'verified' => $validated['verified'] === 'on' || $validated['verified'] === '1' || $validated['verified'] === true,
                'role' => 'nominee',
                'status' => 'submitted'
            ]);

            if (!empty($validated['running_mates_full_name'])) {
                running_mates::create([
                    'nominee_id' => $nominee->id,
                    'running_mates_full_name' => $validated['running_mates_full_name'],
                    'running_mates_hall' => $validated['running_mates_hall'],
                    'running_mates_cgpa' => $validated['running_mates_cgpa'],
                    'running_mates_reg_number' => $validated['running_mates_reg_number'],
                    'running_mates_program' => $validated['running_mates_program'],
                    'running_mates_phone' => $validated['running_mates_phone'],
                    'running_mates_photo_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $validated['running_mates_reg_number'],
                    'running_mates_status' => $validated['running_mates_status'] ?? null,
                ]);
            }

            foreach ([1, 2] as $index) {
                if (isset($validated['guarantor'][$index])) {
                    $guarantorData = $validated['guarantor'][$index];
                    $supporter = supporters::create([
                        'nominee_id' => $nominee->id,
                        'reg_number' => $guarantorData['reg_number'],
                        'name' => $guarantorData['name'],
                        'hall' => $guarantorData['hall'],
                        'department' => $guarantorData['department'],
                        'program' => $guarantorData['program'],
                        'phone' => $guarantorData['phone'],
                        'date' => $guarantorData['date'],
                        'verified' => false,
                        'id_copy_path' => 'https://cdn.ucc.edu.gh/photos/?tag=' . $guarantorData['reg_number'],
                        'email' => $guarantorData['email'],
                        'confirmation_token' => Str::random(40),
                        'confirmed' => false,
                    ]);

                    try {
                        $confirmationUrl = url('/guarantor/confirm/' . $supporter->confirmation_token);
                        $declineUrl = url('/guarantor/decline/' . $supporter->confirmation_token);

                        $emailBody = "
                            Dear {$supporter->name},<br><br>
                            You have been listed as a guarantor for nominee <b>{$nominee->full_name}</b> (Reg No: {$nominee->reg_number}) for the position of <b>{$nominee->position}</b>.<br>
                            Please click the link below to review and confirm or decline your approval:<br><br>
                            <a href=\"{$confirmationUrl}\" style=\"padding:10px 20px;background:#28a745;color:#fff;text-decoration:none;border-radius:5px;\">Accept</a>
                            &nbsp;&nbsp;
                            <a href=\"{$declineUrl}\" style=\"padding:10px 20px;background:#dc3545;color:#fff;text-decoration:none;border-radius:5px;\">Decline</a>
                            <br><br>
                            If you did not expect this email, you can safely ignore it.
                        ";

                        Mail::send([], [], function ($message) use ($supporter, $emailBody) {
                            $message->to($supporter->email)
                                ->subject('Confirm Your Guarantor Approval')
                                ->html($emailBody);
                        });
                    } catch (\Exception $mailEx) {
                        Log::error('Failed to send guarantor confirmation email: ' . $mailEx->getMessage());
                    }
                }
            }

            DB::commit();
        return redirect('normination-landing-page')->with('success', 'Nomination submitted successfully! Guarantors have been notified by email.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Nomination save error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()->back()->with('error', 'An error occurred while saving your nomination.');
        }
    }


    public function confirmGuarantor($token)
    {
        $supporter = supporters::where('confirmation_token', $token)->first();

        if (!$supporter) {
            return redirect('guarantor-confirmation')->with('error', 'Invalid or expired confirmation link.');
        }

        $supporter->verified = true;
      
        $supporter->confirmation_token = null;
        $supporter->save();

        return redirect('guarantor-confirmation')->with('success', 'Thank you for confirming your approval as a guarantor.');
    }

    public function declineGuarantor($token)
    {
        $supporter = supporters::where('confirmation_token', $token)->first();

        if (!$supporter) {
            return back()->with('error', 'Invalid or expired confirmation link.');
        }

        $supporter->verified = false;
    
        $supporter->confirmation_token = null;
        $supporter->save();

        return back()->with('success', 'You have declined to be a guarantor.');
    }

    // Add this method to handle the confirmation link
 


public function checkStatus(Request $request)
{
    try {
        $validated = $request->validate([
            'voucher' => 'required|string',
            'password' => 'required|string'
        ]);

        // Find nomination by voucher
        $ticket = Ticket::where('Voucher', $validated['voucher'])->first();

        if (!$ticket) {
            return response()->json([
                'error' => 'Invalid voucher code or password',
                'status' => 404
            ], 404);
        }

        // Verify the hashed password
        if (!Hash::check($validated['password'], $ticket->Password)) {
            return response()->json([
                'error' => 'Invalid voucher code or password',
                'status' => 404
            ], 404);
        }
         // Find nomination
        $nomination = Nominee::where('reg_number', $ticket->school_id)->first();

        // If no nomination exists yet
        if (!$nomination) {
            return response()->json([
                'success' => true,
                'status' => 'not_started',
                'status_display' => 'Not Started',
                'message' => 'You have not started your nomination. Please begin the nomination process.',
                'position' => null,
                'role' => null,
                'role_display' => null,
                'updated_at' => null,
            ]);
        }

        // Role display mapping
        $roleDisplayMap = [
            'nominee' => 'Nominee',
            'aspirant' => 'Aspirant',
            'candidate' => 'Candidate',
            'nominee' => 'nominee',
        ];

        $response = [
            'success' => true,
            'status' => $nomination->status,
            'role' => $nomination->role ?? 'nominee',
            'role_display' => $roleDisplayMap[$nomination->role] ?? ucfirst((string) $nomination->role),
            'position' => $nomination->position,
            'updated_at' => optional($nomination->updated_at)->format('M d, Y H:i'),
            'status_display' => null,
            'message' => null,
        ];

        // Add status-specific messages and stage labels
        if ($nomination->status === 'draft') {
            $response['message'] = "Your nomination is saved as a draft. Please continue and complete your nomination.";
            $response['status_display'] = 'Draft';
        } 
        elseif ($nomination->status === 'saved') {
            $response['message'] = "Nomination details saved. Please upload all required documents to complete your submission.";
            $response['status_display'] = 'Saved';
        } 
        elseif ($nomination->status === 'submitted') {
            $response['message'] = "Your nomination has been fully submitted and is under review. You will be notified once reviewed.";
            $response['status_display'] = 'Submitted - Pending Review';
        } 
        elseif ($nomination->status === 'rejected') {
            $response['message'] = "Your nomination for {$nomination->position} did not meet the requirements.";
            $response['rejection_reason'] = $nomination->rejection_reason ?? 'No specific reason provided. Please contact the electoral commission.';
            $response['status_display'] = 'Rejected';
        } 
        elseif ($nomination->status === 'approved') {
            // Handle different role levels
            switch ($nomination->role) {
                case 'nominee':
                    $response['message'] = "Congratulations! Your nomination for {$nomination->position} has been approved. You are now a registered nominee.";
                    break;
                case 'aspirant':
                    $response['message'] = "Congratulations! You've been cleared as an aspirant for {$nomination->position}. Proceed to campaign.";
                    break;
                case 'candidate':
                    $response['message'] = "Congratulations! You're now an official candidate for {$nomination->position}. Good luck with your campaign!";
                    break;
                default:
                    $response['message'] = "Your nomination has been approved. Status: " . ($response['role_display'] ?? 'Approved');
                    break;
            }
            $response['status_display'] = 'Approved - ' . ($response['role_display'] ?? 'Approved');
        } 
        else {
            // Fallback for any other status
            $response['message'] = "Your nomination status is being processed. Current status: " . ucfirst($nomination->status);
            $response['status_display'] = ucfirst($nomination->status);
        }

        return response()->json($response);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'error' => 'Validation failed',
            'messages' => $e->errors(),
            'status' => 422
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Status check error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return response()->json([
            'success' => false,
            'error' => 'An unexpected error occurred',
            'message' => 'Unable to check nomination status. Please try again later or contact support.'
        ], 500);
    }
}
   
}
