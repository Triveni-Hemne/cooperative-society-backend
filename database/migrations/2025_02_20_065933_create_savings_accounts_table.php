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
        Schema::create('savings_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_account_id')->constrained('member_depo_accounts')->onDelete('cascade');
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('interest_rate', 5, 2)->default(3.50)->comment('Annual Interest Rate (%)');
            $table->enum('status', ['Active', 'Dormant', 'Closed'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('savings_accounts');
    }
};