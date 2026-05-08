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
        Schema::create('votes', function (Blueprint $table) {
            $table->id(); 
            
            $table->foreignId('poll_id')          
            ->constrained()                
            ->onDelete('cascade');  

            $table->foreignId('candidate_id')          
                ->nullable() // Allow NULL values for skipped votes
                ->constrained();   

            $table->foreignId('user_id')->nullable() // Allow NULL values for skipped votes
            ->constrained();  

            $table->string('poll_type');  
            $table->integer('votes');  
            $table->enum('votes_status', ['voted', 'skipped']); 
            $table->timestamps(); 

             // Ensure a user can only vote once for the same poll & candidate
            $table->unique(['poll_id', 'user_id', 'candidate_id']);
        });

      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
