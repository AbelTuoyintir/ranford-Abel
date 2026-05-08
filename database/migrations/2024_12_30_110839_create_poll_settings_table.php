<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('poll_settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('poll_id')          // Foreign key referencing the polls table
                  ->constrained()                // Automatically references 'polls' table
                  ->onDelete('cascade');
            $table->string('querystring');
                       // The query to be used to get the poll settings

                       $table->boolean('hash_voter_names_numbers')->default(false);
                       $table->boolean('hash_voter_names_Alphabet')->default(true);
                       $table->boolean('show_teaser')->default(false);
                       $table->boolean('hide_profile_pictures')->default(true);
                       $table->boolean('anonymous_voting')->default(true);
                       $table->string('all_portfolios');
                       $table->boolean('show_candidate_cgpa')->default(false);
                       $table->boolean('display_ballot_numbers')->default(true);
                       $table->boolean('allow_candidate_biographies')->default(false);
                       $table->boolean('show_live_results')->default(true);
                       $table->boolean('display_vote_counts')->default(false);
                       $table->boolean('show_percentage_results')->default(false);
                       $table->boolean('send_result_slips')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_settings');
    }
};
