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
        Schema::create('route_maps', function (Blueprint $table) {
            $table->id()->comment('Primary key of the route mappings table.');
            $table->uuid('uuid')->unique()->index()->comment('Unique UUID for the obfuscated route.');
            $table->string('actual_route', 255)->index()->comment('The actual route being obfuscated.');
            $table->timestamps();
        });

        // Optional: Add a comment for the table
        Schema::table('route_maps', function (Blueprint $table) {
            $table->comment('Stores mappings between UUIDs and actual routes for obfuscated URLs.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_maps');
    }
};