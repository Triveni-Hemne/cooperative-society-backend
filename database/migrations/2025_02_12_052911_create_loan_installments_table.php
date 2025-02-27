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
        Schema::create('loan_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('member_loan_accounts')->onDelete('cascade');
            $table->enum('installment_type', ['Monthly', 'Quarterly', 'Yearly']);
            $table->date('mature_date')->nullable();
            $table->date('first_installment_date')->nullable();
            $table->integer('total_installments');
            $table->decimal('installment_amount', 10, 2);
            $table->decimal('installment_with_interest', 10, 2);
            $table->integer('total_installments_paid')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_installments');
    }
};