<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\poll;
use App\Models\User;
use App\Models\Votes;
use App\Models\Setting;
use App\Models\candidate;
use App\Models\Portfolios;
use Illuminate\Http\Request;
use App\Models\election_coalition;
use Illuminate\Support\Facades\DB;
use App\Models\candidate_coalition;
use App\Models\PollSettings;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    //
    public function index()
    {
        
        $settings = Setting::first() ?? new Setting();
        
        return view('livewire.admin.advance-settings', compact('settings'));
    }

    public function ElectionCoalition()
{
    $Archievepolls  = election_coalition::get(); // Fixed variable naming
    

    
    return view('livewire.admin.election-coalition', compact('Archievepolls'));
}


    /**
     * Update network restriction settings
     */
    public function updateNetworkSettings(Request $request)
{
    try {
        // Get existing settings or create new if none exist
        $settings = Setting::first() ?? new Setting();
        
        // Check which setting is being updated
        $settingName = $request->input('setting');
        $value = (bool)$request->input('value');
        
        // Update the appropriate setting based on the toggle that was changed
        if ($settingName === 'school-network') {
            $settings->school_network_restriction = $value;
            
            // If enabling school network, disable normal mode (mutually exclusive)
            if ($value) {
                $settings->normal_mode = false;
            }
        } elseif ($settingName === 'normal-mode') {
            $settings->normal_mode = $value;
            
            // If enabling normal mode, disable school network (mutually exclusive)
            if ($value) {
                $settings->school_network_restriction = false;
            }
        }
        
        $settings->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'settings' => [
                'school_network_restriction' => $settings->school_network_restriction,
                'normal_mode' => $settings->normal_mode
            ]
        ]);
    } catch (\Exception $e) {
        Log::error('Error updating settings: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update settings: ' . $e->getMessage()
        ], 500);
    }
}





     /**
     * Consolidate votes and reset app
     */

        public function fetchPrograms(Request $request)
        {
            $query = $request->input('query');

            // Fetch only the 'Programs' field that matches the query
            $programs = User::where('Programs', 'like', "%{$query}%")
                            ->select('Programs') // Select only the 'Programs' column
                            ->distinct() // Ensure unique program names
                            ->limit(10) // Limit the number of results
                            ->get();

            // Extract only the program names from the result
            $programNames = $programs->pluck('Programs');

            return response()->json($programNames);
        }

public function consolidateVotes()
{
    try {
        DB::beginTransaction();

        $polls = Poll::all();
        $archivedPollIds = [];

        foreach ($polls as $poll) {
            $existsInArchive = DB::table('election_coalitions')->where('id', $poll->id)->exists();

            if (!$existsInArchive) {
                // Count total votes
                $totalVotes = votes::where('poll_id', $poll->id)->count();
                $skippedVotes = votes::where('poll_id', $poll->id)
                                     ->where('votes_status', 'skipped')
                                     ->count() ?? 0;
                
                $totalVoters = User::where('role', 'voter')->count();
                $voters = votes::where('poll_id', $poll->id)->distinct('user_id')->count('user_id');
                $queryString = PollSettings::where('poll_id', $poll->id)->value('querystring');
                $allPortfolios = PollSettings::where('poll_id', $poll->id)->value('all_portfolios');

                // Calculate skipped votes by portfolio
                $skippedVotesBreakdown = [];
                $portfolios = json_decode($allPortfolios, true) ?? [];
                
                foreach ($portfolios as $portfolioName) {
                    $cleanName = trim(stripslashes($portfolioName), '"\'');
                    
                    // Count skipped votes for this specific portfolio
                    $skippedCount = votes::where('poll_id', $poll->id)
                        ->where('votes_status', 'skipped')
                        ->where('poll_type', $cleanName)
                        ->count();
                    
                    $skippedVotesBreakdown[$cleanName] = $skippedCount;
                }

                // Insert into election_coalitions
                DB::table('election_coalitions')->insert([
                    'id' => $poll->id,
                    'title' => $poll->title,
                    'description' => $poll->description,
                    'start_time' => $poll->start_time,
                    'start_date' => $poll->start_date,
                    'end_time' => $poll->end_time,
                    'status' => $poll->status,
                    'poll_type' => $poll->poll_type,
                    'votes_received' => $totalVotes,
                    'all_portfolios' => $allPortfolios,
                    'voters' => $voters,
                    'queryString' => $queryString,
                    'votes_skipped' => $skippedVotes,
                    'skipped_votes_breakdown' => json_encode($skippedVotesBreakdown),
                    'total_voters' => $totalVoters,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $archivedPollIds[] = $poll->id;
            }
        }

        // Process candidates
        $candidates = candidate::whereIn('poll_id', $archivedPollIds)->get();

        if ($candidates->isEmpty() && !empty($archivedPollIds)) {
            Log::info('No candidates found for archived polls with IDs: ' . implode(', ', $archivedPollIds));
            $candidates = candidate::all();
        }

        foreach ($candidates as $candidate) {
            $existsInCoalition = DB::table('candidate_coalitions')->where('id', $candidate->id)->exists();

            if (!$existsInCoalition) {
                $fullName = trim("{$candidate->first_name} " . 
                               ($candidate->middle_name ? "{$candidate->middle_name} " : "") . 
                               "{$candidate->last_name}");

                $portfolio = Portfolios::where('id', $candidate->portfolio_id)->value('name') ?? 'Unknown';
                $totalVotes = votes::where('candidate_id', $candidate->id)->count();

                if (DB::table('election_coalitions')->where('id', $candidate->poll_id)->exists()) {
                    DB::table('candidate_coalitions')->insert([
                        'election_coalition_id' => $candidate->poll_id,
                        'name' => $fullName,
                        'ballot_number' => $candidate->ballot_number,
                        'ghana_card_id' => $candidate->ghana_card_id,
                        'school_id' => $candidate->school_id,
                        'password' => $candidate->password,
                        'role' => $candidate->role,
                        'biography' => $candidate->biography,
                        'team_name' => $candidate->team_name,
                        'portfolio' => $portfolio,
                        'votes' => $totalVotes,
                        'image_path' => $candidate->image_path,
                        'vote_status' => 'winner',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        DB::commit();

        return redirect()->back()->with('success', 'Votes consolidated with accurate portfolio breakdown');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error consolidating votes: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to consolidate votes');
    }
}

public function updateNotificationPrefs(Request $request)
    {
        $validated = $request->validate([
            'setting' => 'required|in:notification_sms,notification_email',
            'value' => 'required|boolean'
        ]);

        $settings = Setting::first() ?? new Setting();

        if ($validated['setting'] === 'notification_sms') {
            $settings->notification = 'sms';
        } elseif ($validated['setting'] === 'notification_email') {
            $settings->notification = 'email';
        }

        $settings->save();

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated successfully',
            'settings' => [
                'notification_sms' => $settings->notification_sms,
                'notification_email' => $settings->notification_email
            ]
        ]);
    }
        
}