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
        Schema::create('users', function (Blueprint $table) {
            $table->id();  // Primary key for user
            $table->string('firstName');  // User's first name
             
            $table->string('middleName')->nullable(); 
            $table->string('lastName');   // User's last name
            $table->string('school_id');
            $table->string('Programs')->nullable();   
            
            $table->string('hall')->nullable();       // User's hall (for example, in a university system)
            $table->string('image')->nullable();
            $table->string('email')->nullable();  // Email address (unique)
            $table->timestamp('email_verified_at')->nullable();  // Timestamp for email verification
            
            $table->string('password');  // User's password
            $table->string('email_verification_token')->nullable();  // Column to store email verification token
            $table->enum('broadcast_status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('email_verification_expires_at')->nullable();  
            $table->string('DOB')->nullable();  // Date of birth
            $table->string('gender'); 
            $table->string('phone')->nullable();  // Phone number
            $table->text('bio')->nullable();  // Bio (nullable)
            $table->rememberToken();  // Token for remembering the user (used for "remember me" feature)
            $table->enum('role', ['admin', 'moderator','super_moderator', 'voter','verification_officer'])->default('voter');  // User's role, with a default value of 'voter'
            $table->enum('type', ['student', 'staff'])->nullable(); 
            $table->enum('action', ['voted', 'verified', 'unverified'])->nullable(); 
            $table->timestamps();  // Created and updated timestamps
        });
        

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');             $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->string('status')->default('inactive');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
