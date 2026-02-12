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
        Schema::create('member_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained('gym_members');

            $table->foreignId('membership_plan_id')
                ->constrained('membership_plans');

            $table->date('start_date');
            $table->date('end_date');

            $table->decimal('amount_paid', 10, 2);

            $table->enum('payment_status', ['Pending', 'Paid', 'Overdue']);

            $table->date('payment_date')->nullable();

            $table->string('order_id', 100)->nullable();
            $table->text('snap_token')->nullable();

            $table->string('transaction_status', 50)->nullable();
            $table->string('payment_method', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_subscriptions');
    }
};
