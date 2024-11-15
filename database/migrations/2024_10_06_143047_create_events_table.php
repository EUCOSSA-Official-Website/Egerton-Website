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
            
            // Is the event a Hackathon?
            $table->enum('category', ['eucossa_tech_friday', 'hackathon']);
            
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('event_day');
            $table->string('speaker');
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade'); // Event creator

            //If the event is a paid event. 
            $table->string('event_charge')->nullable();

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
