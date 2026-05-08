<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE nominees
            MODIFY status ENUM('draft', 'saved', 'submitted', 'approved', 'rejected')
            DEFAULT 'draft'
        ");
    }

    public function down(): void
    {
        DB::statement("UPDATE nominees SET status = 'draft' WHERE status = 'saved'");

        DB::statement("
            ALTER TABLE nominees
            MODIFY status ENUM('draft', 'submitted', 'approved', 'rejected')
            DEFAULT 'draft'
        ");
    }
};

