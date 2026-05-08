<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Poll;
use App\Events\pollStatus;
use App\Models\User;
use App\Models\PollSettings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PublishPoll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:publish-poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change poll to live or active, and complete polls when necessary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the current date and time
        $date = Carbon::now()->format('Y-m-d');
        $now = Carbon::now()->format('H:i:00'); // Round to the nearest minute for comparison
    
        // Activate polls that should have started in the past but were missed
        $missedActivePolls = Poll::where('status', 'inactive')
            ->where('start_date', '<=', $date) // Polls that should have started on or before today
            ->where('start_time', '<=', $now) // Polls that should have started at or before the current time
            ->update(['status' => 'active']);
    
        // Complete polls that should have ended in the past but were missed
        $missedCompletePolls = Poll::where('status', 'active')
            ->where('start_date', '<=', $date) // Polls that should have ended on or before today
            ->where('end_time', '<=', $now) // Polls that should have ended at or before the current time
            ->get();
    
        // Update status to 'complete' for missed polls
        $completedPollsCount = 0;
        foreach ($missedCompletePolls as $poll) {
            $poll->update(['status' => 'complete']);
            $completedPollsCount++;
    
            // Unhash names and enable profile pictures
            $pollSetting = PollSettings::where('poll_id', $poll->id)->first();
            if ($pollSetting) {
                $pollSetting->update([
                    'hide_profile_pictures' => false, // Enable pictures
                    'hash_voter_names_numbers' => false, // Remove number hashing
                    'hash_voter_names_Alphabet' => false, // Remove alphabet hashing
                ]);
            }
    
            $user = User::find($poll->user_id);
            $role = $user ? $user->role : 'guest'; // Default to guest if no user found
            // Dispatch event to notify frontend
            // event(new pollStatus($poll, $role));
        }
    
        // Output results
        if ($missedActivePolls) {
            $this->info("Successfully activated $missedActivePolls missed poll(s) at $now.");
        } else {
            $this->info("No missed polls were activated at $now.");
        }
    
        if ($completedPollsCount > 0) {
            $this->info("Successfully completed $completedPollsCount missed poll(s) at $now and restored original names & images.");
        } else {
            $this->info("No missed polls have been completed at $now.");
        }
    }
}
