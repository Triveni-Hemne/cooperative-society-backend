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
        Schema::create('voucher_entries', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', [
                'Receipt', 'Payment', 'Journal', 'Deposit', 'Withdrawal', 'Loan Payment', 'Fund Transfer'
            ])->notNull();
            $table->string('voucher_num', 50)->nullable();
            $table->string('token_number', 50)->unique()->nullable();
            $table->string('serial_no', 50)->unique()->nullable();
            $table->date('date')->notNull();
            $table->string('receipt_id', 50)->unique()->nullable();
            $table->string('payment_id', 50)->nullable();
            $table->foreignId('ledger_id')->constrained('schedule_ledgers')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('opening_balance', 12, 2)->notNull();
            $table->decimal('current_balance', 12, 2)->notNull();
            $table->text('narration')->nullable();
            $table->text('m_narration')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_entries');
    }
};