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
        Schema::create('running_mates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nominee_id')->unique()->constrained()->onDelete('cascade');
            $table->string('running_mates_full_name');
            $table->decimal('running_mates_cgpa', 5, 2);
            $table->string('running_mates_reg_number')->unique();
            $table->string('running_mates_phone');
            $table->string('running_mates_hall');
            $table->string('running_mates_program');
            $table->string('running_mates_photo_path');
            $table->string('running_mates_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('running_mates');
    }
};
