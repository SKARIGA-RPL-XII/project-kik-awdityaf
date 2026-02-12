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
        Schema::create('gym_expenses', function (Blueprint $table) {
            $table->id();

            $table->date('expense_date');

            $table->string('category', 50);

            $table->text('description')->nullable();

            $table->decimal('amount', 10, 2);

            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->constrained('users');

            $table->dateTime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_expenses');
    }
};