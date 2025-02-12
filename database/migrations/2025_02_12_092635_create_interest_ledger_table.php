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
        Schema::create('interest_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('general_ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained('installment_transactions')->onDelete('cascade');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('amount', 12, 2);
            $table->date('interest_applied_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interest_ledger');
    }
};