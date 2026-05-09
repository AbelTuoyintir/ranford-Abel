<?php

// use App\Events\VoteCast;
// use App\Livewire\AdminLogin;
// use App\Models\ManageMember;
// use App\View\Components\AppLayout;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Artisan, Log, Mail, Route, Schedule, Storage};

use App\Mail\TestMail;
use App\Models\{Nominee, RouteMap, documents};
use App\Events\{LogUserToStrongRoom, UserActivityUpdated};
use App\Http\Controllers\{CandidateController, DashboardController, EmailController, GoogleAuthController, IpAddressController, LoginController, ManageMemberController, NominationController, PollController, PollSystemsController, PortfoliosController, SettingController, StrongroomController, TestController, TicketController, UpdateProfileController, VerifyVoters, VotersController, VotersRegisterController, databaseController, databaseFetchController};

Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');     // clears all caches (routes, config, views)
    Artisan::call('view:clear');         // clear compiled blade views
    Artisan::call('config:clear');       // clear config cache
    Artisan::call('cache:clear');        // clear general cache
    Artisan::call('route:clear');        // clear route cache
    Artisan::call('view:cache');         // recompile views freshly
    Artisan::call('storage:link');       // recreate storage symlink if needed
    return 'All caches cleared, views rebuilt, and storage linked.';
});

Schedule::command('app:publish-poll')->everyMinute();
Route::view('/','livewire.landing-page')->name('/');
Route::view('/google-verification','livewire.google-verification')->name('/google-verification');
Route::view('/guarantor-confirmation','errors.supporterError')->name('/guarantor-confirmation');
Route::view('/admin','livewire.admin-login')->name('/admin');
Route::view('/voter-login','livewire.stud-login')->name('/student');    
Route::view('/candidate-login','livewire.candidate-login')->name('/candidate');
Route::get('/public-room', [StrongroomController::class, 'LoginPublicRoomPage'])->name('/public-room');
Route::post('/public-login', [StrongroomController::class, 'LoginPublicRoom'])->name('/public-login');
Route::get('/normination-landing-page',[NominationController::class, 'nominationLandingPage'])->name('/normination-landing-page');
Route::get('/normination-',[NominationController::class, 'nominationPrintPage'])->name('/normination-');
Route::post('/normination',[NominationController::class, 'save'])->name('nominee.store');
Route::post('/nomination-print', [TicketController::class, 'NorminationForm_Print'])->name('nomination.print');
Route::post('/nomination-login', [TicketController::class, 'NorminationLogin'])->name('nomination.login');
Route::post('/nomination/documents/{user}', [NominationController::class, 'storeDocuments'])->name('nomination.documents.store');
Route::get('/nomination-forms', [NominationController::class, 'index'])->name('nomination.forms');
Route::get('/documents-uploads', [NominationController::class, 'Documents'])->name('nomination.documents');
Route::get('/search-nominee-user', [NominationController::class, 'searchNominee'])->name('search-nominee-user');
Route::post('/nomination/status', [NominationController::class, 'checkStatus']);
Route::get('/guarantor/confirm/{token}', [NominationController::class, 'confirmGuarantor'])->name('guarantor.confirm');
Route::get('/guarantor/decline/{token}', [NominationController::class, 'declineGuarantor'])->name('guarantor.decline');
Route::get('/{uuid}', function ($uuid) {
    return "This is UUID: $uuid";
})->where('uuid', '[0-9a-fA-F-]+'); // Ensure only valid UUIDs match




Route::get('/send-mail', function () {
    // $details = [
    //     'content' => 'Hello! This is a test email sent from Laravel.'
    // ];

    // Mail::to('rnketia25@gmail.com')->send(new TestMail($details));

    // return 'Email sent successfully!';

    $nominees = Nominee::with(['supporters', 'runningMate'])
    ->get();

foreach ($nominees as $nominee) {
    foreach ($nominee->supporters as $supporter) { // Note: Typo in variable name (supporter vs supporter)
        if (!empty($supporter->confirmation_token)) {
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
            
            Log::info("Confirmation email sent to supporter: {$supporter->email} for nominee: {$nominee->id}");
        }
   }
}
});



Route::middleware(['restrict.ip'])->group(function () {
    // Routes to be restricted
    Route::post('/start-election',[PollController::class,'StartElection'])->name('settings.start-election');
    Route::post('/end-election',[PollController::class,'StopElection'])->name('settings.end-election');
    Route::post('/settings/update-notifications', [SettingController::class, 'updateNotificationPrefs'])->name('settings.update-notification');
    Route::view('/admin','livewire.admin-login')->name('/admin');
    Route::view('/','livewire.landing-page')->name('/');
    Route::get('/nomination-management', [TicketController::class, 'ManageNorminees'])->name('nomination-management');
    Route::view('/login','livewire.stud-login')->name('/login');  
    Route::view('/candidate-login','livewire.candidate-login')->name('/candidate');
    Route::view('/google-verification','livewire.google-verification')->name('/google-verification');
    Route::view('/feedback','livewire.email.feedback')->name('feedback');
    Route::view('/voterSlip','livewire.email.voter_slip')->name('voterSlip');
    Route::get('verify-voter/{token}', [EmailController::class, 'verifyVoter'])->name('verify.voter');
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
    Route::post('/login',[LoginController::class,'login'])->name('login');
    Route::post('/login/candidate',[LoginController::class,'loginCandidate'])->name('loginCandidate');
    Route::post('/login/Voter',[LoginController::class,'loginVoter'])->name('loginVoter');
    Route::get('/camp', [StrongroomController::class, 'camp'])->name('/camp');
    Route::get('/update/candidate/profile', [UpdateProfileController::class, 'candidate'])->name('/update-candidate-profile');
    Route::post('/profile/candidate/update', [UpdateProfileController::class, 'updateCandidate'])->name('profile.candidate.update');
    Route::get('/voters-register',[VotersRegisterController::class, 'index'])->name('/voters/register');
    Route::middleware(['auth'])->group(function () {
    //Route::get('/public-room', [StrongroomController::class, 'LoginPublicRoomPage'])->name('/public-room');    
        // Route::view('/dashboard','livewire.admin.dashboard')->name('/dashboard');
    Route::patch('/nominees/{nominee}/update-portfolio', [NominationController::class, 'updatePortfolio'])->name('nominees.updatePortfolio');
        
        Route::patch('/nominees/{nominee}/update-portfolio', [NominationController::class, 'updatePortfolio'])->name('nominees.updatePortfolio');
        // Route::get('/secure-document/{document}', function (documents $document) {
        //     // Debugging: Log the exact path being checked
        //     $relativePath = $document->path;
        //     $absolutePath1 = storage_path('app/' . $relativePath);
        //     $absolutePath2 = storage_path('app/private/' . $relativePath);
            
        //     Log::debug('File access attempt', [
        //         'document_id' => $document->id,
        //         'db_path' => $relativePath,
        //         'attempted_path1' => $absolutePath1,
        //         'attempted_path2' => $absolutePath2,
        //         'file_exists1' => file_exists($absolutePath1),
        //         'file_exists2' => file_exists($absolutePath2),
        //         'storage_exists' => Storage::exists($relativePath),
        //     ]);
        
        //     // Determine the correct file path
        //     $foundPath = null;
        //     foreach ([$absolutePath1, $absolutePath2] as $path) {
        //         if (file_exists($path)) {
        //             $foundPath = $path;
        //             break;
        //         }
        //     }
        
        //     if (!$foundPath) {
        //         abort(404, "File not found. Checked locations:\n- {$absolutePath1}\n- {$absolutePath2}");
        //     }
        
        //     // Admin bypass
        //     if (auth()->user()->role === 'admin') {
        //         return response()->file($foundPath, [
        //             'Content-Type' => $document->mime_type,
        //             'Content-Disposition' => Str::startsWith($document->mime_type, 'image/') 
        //                 ? 'inline' 
        //                 : 'attachment'
        //         ]);
        //     }
        
        //     // Normal user flow
        //     if (auth()->user()->cannot('view', $document)) {
        //         abort(403);
        //     }
        
        //     return response()->file($foundPath, [
        //         'Content-Type' => $document->mime_type,
        //         'Content-Disposition' => Str::startsWith($document->mime_type, 'image/') 
        //             ? 'inline' 
        //             : 'attachment; filename="' . $document->original_name . '"'
        //     ]);
        // })->name('secure.document');

     

Route::get('/secure-document/{document}', function (documents $document) {
    // Permission check (admin or owner)
    if (auth()->user()->role !== 'admin' && auth()->user()->cannot('view', $document)) {
        abort(403);
    }

    $disk = Storage::disk('public');
    $path = $document->path;

    if (!$disk->exists($path)) {
        abort(404);
    }

    $file = $disk->get($path);
    $mime = $disk->mimeType($path); // no column needed, reads from file
    $filename = basename($path);

    // For images, show inline; otherwise force download
    if (str_starts_with($mime, 'image/')) {
        return response($file, 200)->header('Content-Type', $mime);
    }

    return response($file, 200)
        ->header('Content-Type', $mime)
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
})->name('secure.document');
        
        Route::post('/nominees/{nominee}/promote', [NominationController::class, 'promote'])->name('nominees.promote');
        Route::delete('/nominees/{nominee}', [NominationController::class, 'disqualify'])->name('nominees.disqualify'); 
        Route::post('/nominees/{nominee}', [NominationController::class, 'requalify'])->name('nominees.requalify'); 
        Route::get('/nominees/{nominee}', [NominationController::class, 'show'])->name('nominees.show');
        Route::patch('/{document}/verify', [NominationController::class, 'verify'])->name('documents.verify');
        Route::delete('/{document}/reject', [NominationController::class, 'reject'])->name('documents.reject');
       
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('/dashboard');
    // Add more routes as needed
        Route::get('/generate-voucher', [TicketController::class, 'index'])->name('/generate-voucher');
        Route::post('/vouchers', [TicketController::class, 'store'])->name('vouchers.store');
        Route::get('/admin/tickets', [TicketController::class, 'vouchers'])->name('admin.tickets');
        Route::delete('/admin/tickets/{ticket}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');
        Route::get('/admin/tickets/{ticket}', [TicketController::class, 'show'])->name('admin.tickets.show');
        Route::post('/admin/tickets/{ticket}/reset-password', [TicketController::class, 'resetPassword'])->name('admin.tickets.reset-password');
        Route::get('/admin/tickets/export/csv', [TicketController::class, 'exportCSV'])->name('admin.tickets.export');
        Route::get('/update-email', [UpdateProfileController::class, 'UpdateEmailView'])->name('/update-email');
        Route::get('/update-email-forms', [UpdateProfileController::class, 'showEmailUpdateForm'])->name('students.email-update');


        // Search by school ID
        Route::get('/search-student', [UpdateProfileController::class, 'search'])->name('students.search');

        // Update email
        Route::put('/students/{id}/update-email', [UpdateProfileController::class, 'updateEmail'])->name('students.update-email');
        Route::get('/super-strongroom',[StrongroomController::class, 'superStrongRoom'])->name('/super-strongroom');
        Route::get('/staff-strongroom', [StrongroomController::class, 'super_StrongRoom'])->name('strongroom.super');
        Route::view('/strong-room','livewire.admin.strongrooms')->name('/strong-room');
        Route::view('/overview','livewire.admin.overview')->name('/overview');
        Route::get('/ipblocker', [IpAddressController::class, 'index'])->name('/ipblocker');
        // IP Address Operations
        Route::post('/ip-addresses', [IpAddressController::class, 'store'])->name('ip-addresses.store');
        Route::get('/ip-addresses/{ipAddress}/edit', [IpAddressController::class, 'edit'])->name('ip-addresses.edit');
        Route::put('/ip-addresses/{ipAddress}', [IpAddressController::class, 'update'])->name('ip-addresses.update');
        Route::delete('/ip-addresses/{ipAddress}', [IpAddressController::class, 'destroy'])->name('ip-addresses.destroy');
        Route::put('/ip-addresses/{ipAddress}/toggle', [IpAddressController::class, 'toggleActive'])->name('ip-addresses.toggle');


        Route::get('/election-coalition', [SettingController::class, 'ElectionCoalition'])->name('/election-coalition');
        // Route::view('/camp','livewire.candidates.camp')->name('/camp');
        Route::get('/public-view', [StrongroomController::class, 'ShowVoterResults'])->name('/public-view');
        // Route::view('/public-view','')->name('/public-view');//for voters to see what is going on

        Route::get('/display/voting-card',[VotersController::class, 'displayCards'])->name('/display/voting-card');

        Route::view('/candidate-form','livewire.admin.candidate-forms')->name('/candidate-form');
        Route::view('/analysis','livewire.admin.analysis-page')->name('/analysis');
        Route::view('/result','livewire.admin.result')->name('/result');
        
        Route::view('/admin-result','livewire.admin.admin-result')->name('admin-result');


        Route::get('/fetch-programs', [SettingController::class, 'fetchPrograms']);
        Route::post('/logout',[LoginController::class,'logout'])->name('logout');
        Route::post('/profile/update', [UpdateProfileController::class, 'update'])->name('profile.update');
        Route::post('/create-poll', [PollController::class, 'CreatePoll'])->name('/create-poll');
        Route::post('/polls/filter', [PollController::class, 'filter'])->name('/polls.filter');
        Route::post('/add-candidate', [CandidateController::class, 'AddCandidate'])->name('add-candidate');
        Route::post('/add-moderator',[ManageMemberController::class, 'AddModerator'])->name('/add-moderator');
        Route::post('/add-verification-officer',[ManageMemberController::class, 'AddVerificationOfficer'])->name('/add-verification-officer');
        Route::put('/portal-verification',[VerifyVoters::class, 'verify'])->name('voter.verify');
        Route::post('automatic-verification',[VerifyVoters::class, 'updateAutomatic'])->name('voter.automaticVerify');
        Route::get('/voter/{poll_type}', [VotersController::class, 'voterPage'])->name('/voter');
        Route::get('/search-user', [ManageMemberController::class, 'searchUser'])->name('search-user');
        Route::get('/update/profile', [UpdateProfileController::class, 'index'])->name('/update-profile');
        Route::get('/manageMembers', [ManageMemberController::class, 'manageMembers'])->name('/manage-members');
        Route::put('/update-voter', [VerifyVoters::class, 'update'])->name('voter.update');
        Route::get('/log', [LoginController::class, 'showLogs'])->name('/log');
        Route::get('/verification',[VerifyVoters::class, 'GetVoters'])->name('/verification');
        Route::get('/automatic-verification',[VerifyVoters::class, 'automatic'])->name('/automatic-verification');
        Route::get('/create-poll',[PollController::class, 'getPollCounts'])->name('/getPollCounts');
        Route::get('/details', [LoginController::class, 'showDetails'])->name('/details');
        Route::get('/strong-room', [StrongroomController::class, 'index'])->name('/strong-room');
        //Route::get('/public-room', [StrongroomController::class, 'LoginPublicRoomPage'])->name('/public-room');
        Route::get('/database',[databaseController::class, 'index'])->name('database');
        
        // Update candidate
        Route::put('/candidates/{id}', [CandidateController::class, 'deleteCandidate']);
        // Delete candidate
        Route::delete('/candidates/{id}/delete', [CandidateController::class, 'destroy']);
        // Update moderator
        Route::put('/moderators/{id}', [ManageMemberController::class, 'update']);
        // Delete moderator
        Route::delete('/moderators/{id}/delete', [ManageMemberController::class, 'destroy']);
        Route::delete('/delete-candidate/{id}', [CandidateController::class, 'deleteCandidate']);
        Route::get('/get-candidates', [CandidateController::class, 'GetPollCandidate'])->name('poll.candidates');
        Route::get('/portfolios-by-poll', [PortfoliosController::class, 'PopulatePortfoliosCandidate'])->name('candidate.portfolios');
        Route::get('/portfolios', [PortfoliosController::class, 'index'])->name('portfolios.index');
        Route::post('/portfolios', [PortfoliosController::class, 'create'])->name('portfolios.create');
        Route::get('/portfolios/{id}/edit', [PortfoliosController::class, 'edit'])->name('portfolios.edit');
        Route::put('/portfolios/{id}', [PortfoliosController::class, 'update'])->name('portfolios.update');
        Route::delete('/portfolios/{id}', [PortfoliosController::class, 'destroy'])->name('portfolios.destroy');
        Route::post('/portfolios/submit', [PortfoliosController::class, 'PollSubmitPortfolios'])->name('portfolios.submit');
        Route::get('/get-portfolios', [PortfoliosController::class, 'getPortfolios'])->name('portfolios.get');
        Route::post('/pollsettings', [PollSystemsController::class, 'Settings'])->name('pollsettings');
        Route::post('/eligible-voters', [PollController::class, 'getEligibleVoters'])->name('eligible.voters');
        ///reverb
        Route::post('/submit-vote', [VotersController::class, 'submitVote']);
        // Route::post('/submit-vote', [VotersController::class, 'submitVote'])->name('submit.vote');
        Route::get('/check-vote-status/{pollId}', [VotersController::class, 'checkUserVoteStatus']);
        //fetching all students data into the database
        Route::post('/fetch-student-data', [databaseController::class, 'fetchStudents'])->name('fetchStudents');
        Route::post('/fetch-staff-data', [databaseController::class, 'fetchStaff'])->name('fetchStaff');
        Route::post('/import',[VerifyVoters::class, 'import'])->name('import');
        Route::post('/importStaff',[VerifyVoters::class, 'importStaff'])->name('importStaff');
        // Settings routes
        Route::post('/settings/update-network', [SettingController::class, 'updateNetworkSettings'])->name('settings.update-network');
        Route::post('/settings/consolidate-votes', [SettingController::class, 'consolidateVotes'])->name('settings.consolidate-votes');
        Route::get('/advance-settings', [SettingController::class, 'index'])->name('/advance-settings');


                                
    });
});


















