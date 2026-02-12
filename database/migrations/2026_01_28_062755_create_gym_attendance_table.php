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
        Schema::create('gym_attendance', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained('gym_members');

            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();

            $table->date('date');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_attendance');
    }
};
