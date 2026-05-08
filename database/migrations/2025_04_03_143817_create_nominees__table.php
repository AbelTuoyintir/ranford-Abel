<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomineesTable extends Migration
{
    public function up()
    {
        Schema::create('nominees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('reg_number')->unique();
            $table->string('position');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('hall');
            $table->string('program');
            $table->decimal('nominee_cgpa', 5, 2);
            $table->boolean('medical_clearance')->default(false)->nullable();
            $table->boolean('fee_paid')->default(false)->nullable();
            // $table->boolean('declaration_signed')->default(false);
            $table->string('photo_path')->nullable();
            $table->boolean('verified')->default(false)->nullable();
            $table->enum('role', ['applicant','nominee', 'aspirant', 'candidate'])->default('nominee');
            $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('nominees');
    }
}
