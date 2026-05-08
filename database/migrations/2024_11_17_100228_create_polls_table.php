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
        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->longText('description');               // Title of the poll
            $table->time('start_time');       // Start time of the poll
            $table->time('end_time')->nullable();         // End time of the poll
            $table->date('start_date');             // Date of the poll
            $table->enum('status', ['active', 'inactive','complete']); // Status of the poll (you can change values based on your needs)
            $table->string('image')->nullable(); 
            $table->enum('poll_type', ['UCC GENERAL VOTING', 'DEPARTMENT','HALL', 'SPECIAL VOTING']);  // List of valid poll types
            $table->timestamps();                  // Laravel automatically manages created_at and updated_at columns
        });
        
    }

    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polls');
    }



};
