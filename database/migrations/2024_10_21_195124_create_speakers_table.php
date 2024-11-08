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
        Schema::create('speakers', function (Blueprint $table) {
            $table->id();

            $table->string('email');
            $table->string('name');
            $table->string('year_of_study');
            $table->string('other_year')->nullable();
            $table->string('topic');
            $table->text('description');
            $table->string('stack');
            $table->string('skill');
            $table->string('phone');
            $table->unsignedBigInteger('creator_id');

            $table->timestamps();

            // If the speaker has been approved/disapproved by Admin
            $table->timestamp("approved")->nullable();
            $table->timestamp("disapproved")->nullable();

            // Optional: Add foreign key for creator_id if needed
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
