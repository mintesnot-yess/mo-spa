<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Optional: Clean duplicates first if needed (not shown here)
        Schema::table('attendances', function (Blueprint $table) {
            $table->unique(['person_id', 'date'], 'unique_person_date');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique('unique_person_date');
        });
    }
};