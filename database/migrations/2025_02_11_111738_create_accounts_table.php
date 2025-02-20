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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->string('account_no', 50)->unique();
            $table->string('account_name', 50);
            $table->string('name', 255);
            $table->enum('account_type', ['Deposit', 'Loan', 'Savings', 'Investment']);
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->date('start_date');
            $table->decimal('open_balance', 12, 2)->default(0.00);
            $table->decimal('balance', 12, 2)->default(0.00);
            $table->boolean('closing_flag')->default(false);
            $table->boolean('add_to_demand')->default(false);
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->enum('installment_type', ['Monthly', 'Quarterly', 'Yearly'])->nullable();
            $table->decimal('installment_amount', 12, 2)->nullable();
            $table->integer('total_installments_paid')->default(0);
            $table->date('closing_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};