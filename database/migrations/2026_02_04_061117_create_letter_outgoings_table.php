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
    Schema::create('letter_outgoings', function (Blueprint $table) {

        $table->id();

        $table->date('letter_date');

        $table->string('letternumber')->unique();

        $table->string('letterdestination');

        $table->string('lettersubject');

        $table->string('letterstatus')->nullable();

        // SAMAKAN DENGAN MODEL: letterdescriptions
        $table->text('letterdescriptions')->nullable();

        $table->string('letterfile')->nullable();

        $table->boolean('is_realis')->default(false);

        $table->boolean('is_tindak')->default(false);

        $table->text('information')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letter_outgoings');
    }
};