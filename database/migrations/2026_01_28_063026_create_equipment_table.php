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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            $table->string('equipment_name', 100);
            $table->string('category', 50);
            $table->string('brand', 50);

            $table->date('purchase_date');

            $table->enum('condition_status', [
                'Excellent',
                'Good',
                'Fair',
                'Poor',
                'Out of Order'
            ]);

            $table->date('maintenance_date')->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
