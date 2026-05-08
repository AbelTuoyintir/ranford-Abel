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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id(); // This creates an unsigned big integer column named 'id'
            $table->foreignId('poll_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->text('hall')->nullable();
            $table->string('ballot_number');
            $table->string('cgpa');
            $table->string('ghana_card_id');
            $table->text('biography')->nullable();
            $table->text('teaser')->nullable();
            $table->text('team_name');
            $table->string('password');
            $table->string('school_id');
            $table->enum('role', ['candidate'])->default('candidate');  // User's role, with a default value of 'voter'
            $table->unsignedBigInteger('portfolio_id'); // Ensure this matches the 'id' type in 'portfolios'
            $table->foreign('portfolio_id')->references('id')->on('portfolios')->onDelete('cascade');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
