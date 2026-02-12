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
        Schema::create('member_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained('gym_members');

            $table->string('category', 50);

            $table->string('subject', 255);

            $table->text('description');

            $table->enum('priority', ['Low', 'Medium', 'High']);

            $table->enum('status', ['Open', 'In Progress', 'Resolved', 'Closed']);

            $table->text('admin_response')->nullable();

            $table->dateTime('responded_at')->nullable();

            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_reports');
    }
};
