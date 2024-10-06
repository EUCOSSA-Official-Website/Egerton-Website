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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('event_day');
            $table->string('speaker');
            $table->boolean('reminder')->default(false);
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade'); // Event creator

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
