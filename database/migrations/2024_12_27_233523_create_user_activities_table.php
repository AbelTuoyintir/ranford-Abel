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
        Schema::create('user_activities', function (Blueprint $table) {
            $table->id();  // Auto-incremented primary key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');  // Foreign key to users table
            $table->string('school_id');            
            $table->string('session_id')->nullable();  // Foreign key to sessions table (nullable if no active session)
            $table->string('action'); // Action name (e.g., 'click', 'scroll', 'submit')
            $table->text('details')->nullable(); // Additional details about the action (e.g., element clicked, page visited)
            $table->timestamps(); // Automatically includes created_at and updated_at timestamps
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};
