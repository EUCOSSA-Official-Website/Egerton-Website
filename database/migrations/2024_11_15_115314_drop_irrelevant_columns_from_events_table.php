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
        // Drop only if the columns exist (prevents fresh installs / differing schemas from failing)
        foreach (['mpesa_callback', 'receipt_number', 'amount_paid'] as $column) {
            if (Schema::hasColumn('events', $column)) {
                Schema::table('events', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Best-effort restore (nullable to avoid breaking existing data)
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'mpesa_callback')) {
                $table->text('mpesa_callback')->nullable();
            }
            if (!Schema::hasColumn('events', 'receipt_number')) {
                $table->string('receipt_number')->nullable();
            }
            if (!Schema::hasColumn('events', 'amount_paid')) {
                $table->decimal('amount_paid', 12, 2)->nullable();
            }
        });
    }
};
