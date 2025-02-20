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
        Schema::create('bank_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignId('depo_account_id')->nullable()->constrained('member_depo_accounts')->onDelete('cascade');
            $table->string('name');
            $table->enum('investment_type', ['FD', 'RD', 'Other']);
            $table->decimal('interest_rate', 5, 2)->default(0.00);
            $table->date('opening_date');
            $table->decimal('opening_balance', 12, 2);
            $table->decimal('current_balance', 12, 2);
            $table->date('maturity_date');
            $table->integer('deposit_term_days')->nullable();
            $table->integer('months')->nullable();
            $table->integer('years')->nullable();
            $table->decimal('fd_amount', 12, 2)->nullable();
            $table->decimal('monthly_deposit', 12, 2)->nullable();
            $table->integer('rd_term_months')->nullable();
            $table->decimal('maturity_amount', 12, 2);
            $table->decimal('interest', 12, 2);
            $table->decimal('interest_receivable', 12, 2);
            $table->string('interest_frequency')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_investments');
    }
};