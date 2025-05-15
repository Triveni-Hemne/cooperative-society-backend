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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('member_depo_account_id')->nullable()->constrained('member_depo_accounts')->onDelete('set null');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->foreignId('member_loan_account_id')->nullable()->constrained('member_loan_accounts')->onDelete('set null');
            $table->decimal('amount', 12, 2)->notNull();
            $table->date('payment_date')->notNull();
            $table->enum('method', ['Cash', 'Bank Transfer', 'Cheque']);
            $table->enum('status', ['Pending', 'Completed', 'Failed'])->default('Pending');
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};