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
        Schema::create('gym_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users');

            $table->string('member_code', 20);
            $table->string('phone', 15);
            $table->text('address')->nullable();

            $table->date('birth_date');

            $table->enum('gender', ['Male', 'Female']);

            $table->string('emergency_contact', 100);
            $table->string('emergency_phone', 15);

            $table->date('join_date');

            $table->enum('status', ['Active', 'Inactive', 'Suspended'])
                ->default('Active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_members');
    }
};