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
            $table->foreignId('ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignId('member_depo_account_id')->nullable()->constrained('member_depo_accounts')->onDelete('set null');
            $table->foreignId('member_loan_account_id')->nullable()->constrained('member_loan_accounts')->onDelete('set null');
            $table->decimal('amount', 12,2);
            $table->decimal('debit_amount', 12, 2)->default(0.00);
            $table->decimal('credit_amount', 12, 2)->default(0.00);
            $table->decimal('opening_balance', 12, 2)->notNull();
            $table->decimal('current_balance', 12, 2)->notNull();
            $table->enum('transaction_mode', ['Cash', 'Bank', 'Online', 'Cheque'])->nullable();
            $table->enum('payment_mode', ['NEFT', 'IMPS', 'UPI', 'RTGS', 'Cheque', 'Cash', 'Bank Transfer'])->nullable();
            $table->string('reference_number', 100)->nullable();
            $table->boolean('is_reversed')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('entered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');          
            $table->date('to_date')->nullable();
            $table->date('from_date')->nullable();
            $table->text('narration')->nullable();
            $table->text('m_narration')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            // Indexing for Performance
            $table->index('account_id');
            $table->index('member_loan_account_id');
            $table->index('member_depo_account_id');
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
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