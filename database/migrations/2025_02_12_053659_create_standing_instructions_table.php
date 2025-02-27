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
        Schema::create('standing_instructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_ledger_id')->nullable()->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('credit_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->decimal('credit_transfer', 12, 2)->nullable();
            $table->foreignId('debit_ledger_id')->nullable()->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('debit_account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->decimal('debit_transfer', 12, 2)->nullable();
            $table->date('date');
            $table->enum('frequency', ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'Yearly']);
            $table->integer('no_of_times');
            $table->integer('bal_installment');
            $table->date('execution_date');
            $table->decimal('amount', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standing_instructions');
    }
};