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
        Schema::table('event_user_reactions', function (Blueprint $table) {
            // Modify the reaction column to allow NULL values
            $table->enum('reaction', ['like', 'dislike'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_user_reactions', function (Blueprint $table) {
            // Revert the reaction column to NOT NULL if needed
            $table->enum('reaction', ['like', 'dislike'])->nullable(false)->change();
        });
    }
};
