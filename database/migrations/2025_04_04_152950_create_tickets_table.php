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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('Voucher');
            $table->string('Password');
            
            // Foreign key to nominees.id
            // $table->unsignedBigInteger('nominee_id')->nullable();
            // $table->foreign('nominee_id')->references('id')->on('nominees')->onDelete('set null');
            
            $table->string('school_id');

            $table->string('expire_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
