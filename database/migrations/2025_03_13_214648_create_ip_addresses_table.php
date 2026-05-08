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
        Schema::create('ip_addresses', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('address')->unique(); // IP address (e.g., 192.168.1.1)
            $table->string('label'); // Label for the IP (e.g., Web Server)
            $table->boolean('active')->default(false); // Active status (true/false)
            $table->dateTime('date_added'); // Date when the IP was added
            $table->string('last_active')->nullable(); // Last active timestamp
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_addresses');
    }
};
