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
        Schema::create('supporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nominee_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('reg_number');
            $table->string('hall');
            $table->string('email')->nullable(); 
            $table->string('department');
            $table->string('program');
            $table->string('phone');
            $table->date('date');
            $table->string('id_copy_path');
            $table->boolean('verified')->default(false);
            $table->string('confirmation_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supporters');
    }
};
