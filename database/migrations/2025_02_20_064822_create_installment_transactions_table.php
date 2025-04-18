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
        Schema::create('installment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_account_id')->constrained('member_depo_accounts')->onDelete('cascade');
            $table->integer('installment_no');
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->decimal('interest_earned', 10, 2)->nullable();
            $table->decimal('total_balance', 12, 2);
            $table->decimal('total_balance', 12, 2);
             $table->foreignId('created_by')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_transactions');
    }
};