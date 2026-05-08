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
        Schema::create('election_coalitions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title'); // Title of the poll
            $table->longText('description'); // Description of the poll
            $table->time('start_time'); // Start time of the poll
            $table->date('start_date'); 
            $table->string('all_portfolios');
            
            $table->time('end_time')->nullable(); // End time of the poll
            $table->enum('status', ['active', 'inactive', 'complete']); // Status of the poll
            $table->string('poll_type'); // Type of poll (e.g., UCC GENERAL VOTING, DEPARTMENT, etc.)
            $table->string('querystring');
            $table->integer('votes_received')->default(0); // Number of votes received by the candidate
            $table->json('skipped_votes_breakdown')->nullable();
            $table->integer('votes_skipped')->default(0); // Status of the vote
            $table->integer('total_voters')->default(0);
            $table->integer('voters');
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_coalitions');
    }
};
