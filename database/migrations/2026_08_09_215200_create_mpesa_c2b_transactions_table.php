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
        Schema::create('mpesa_c2b_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trans_id')->unique();
            $table->string('transaction_type')->nullable();
            $table->timestamp('trans_time')->nullable();
            $table->decimal('trans_amount', 15, 2);
            $table->string('business_short_code')->nullable();
            $table->string('bill_ref_number')->nullable();
            $table->decimal('org_account_balance', 15, 2)->nullable();
            $table->string('msisdn')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpesa_c2b_transactions');
    }
};
