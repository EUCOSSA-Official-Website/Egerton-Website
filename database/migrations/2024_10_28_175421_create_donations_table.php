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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            // To see whether the donor is a guest/our own member
            $table->enum('donor', ['guest', 'member']);
            $table->string('donor-name')->nullable();

            $table->integer('amount');

            // The Source of The Money
            $table->enum('source', ['mpesa', 'paystack']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
