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
        Schema::create('ms_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phonenumber');
            $table->string('username')->unique();
            $table->string('job');
            $table->string('password');
            $table->string('role');
            $table->timestamp('createddate')->nullable();
            $table->string('createdby')->nullable();
            $table->timestamp('updateddate')->nullable();
            $table->string('updatedby')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_users');
    }
};