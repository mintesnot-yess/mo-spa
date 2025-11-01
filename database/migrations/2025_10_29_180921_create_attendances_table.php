<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('person_id'); // Using string since your example has '10001 with quote
            $table->date('date');
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('late')->default('0 min');
            $table->string('early_leave')->default('0 min');
            $table->string('attended')->default('0 min');
            $table->string('absent')->default('0 min');
            $table->string('worked')->default('0 min');
            $table->string('break')->default('0 min');
            $table->string('leave_type')->nullable();
            $table->string('leave')->default('0 min');
            $table->string('ot1')->default('0 min');
            $table->string('ot2')->default('0 min');
            $table->string('ot3')->default('0 min');
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['person_id', 'date']);
            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};