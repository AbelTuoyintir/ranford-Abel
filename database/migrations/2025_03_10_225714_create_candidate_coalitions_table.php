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
        Schema::create('candidate_coalitions', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('election_coalition_id')->constrained()->onDelete('cascade'); // Foreign key to election_coalition
            $table->string('name'); // Name of the candidate
            $table->string('ballot_number'); // Ballot number of the candidate
            $table->string('school_id');
            $table->string('ghana_card_id'); // Ghana Card ID of the candidate
            $table->text('biography')->nullable(); // Biography of the candidate
            $table->string('image_path')->nullable();
            $table->string('team_name'); // Team name of the candidate
            $table->string('portfolio'); // Portfolio of the candidate
            $table->string('password');
            $table->string('role');
            $table->string('votes'); // Portfolio of the candidate
            $table->enum('vote_status', ['winner', 'loser']); // Status of the vote
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_coalitions');
    }
};
