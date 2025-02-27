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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('member_depo_account_id')->nullable()->constrained('member_depo_accounts')->onDelete('set null');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignId('member_loan_account_id')->nullable()->constrained('member_loan_accounts')->onDelete('set null');
            $table->string('receipt_no', 50)->unique()->notNull();
            $table->foreignId('issued_by')->constrained('users')->onDelete('cascade');
            $table->date('issue_date')->notNull();
            $table->decimal('amount', 12, 2)->notNull();
            $table->enum('method', ['Cash', 'Bank Transfer', 'Cheque'])->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};