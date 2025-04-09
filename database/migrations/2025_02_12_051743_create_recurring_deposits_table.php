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
        Schema::create('recurring_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_account_id')->constrained('member_depo_accounts')->onDelete('cascade');
            $table->integer('rd_term_months')->notNull();
            $table->decimal('open_interest', 10, 2)->notNull();
            $table->decimal('maturity_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_deposits');
    }
};