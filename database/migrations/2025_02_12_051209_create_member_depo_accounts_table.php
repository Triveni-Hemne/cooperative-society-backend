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
        Schema::create('member_depo_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('acc_no', 50)->unique()->notNull();
            $table->string('name', 255)->notNull();
            $table->decimal('interest_rate', 5, 2)->notNull();
            $table->date('ac_start_date')->notNull();
            $table->decimal('open_balance', 10, 2)->notNull();
            $table->decimal('balance', 10, 2)->notNull();
            $table->boolean('closing_flag')->default(false);
            $table->boolean('add_to_demand')->default(false);
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->string('page_no', 50)->nullable();
            $table->enum('installment_type', ['Monthly', 'Quarterly', 'Yearly'])->nullable();
            $table->decimal('installment_amount', 10, 2)->notNull();
            $table->integer('total_installments')->nullable();
            $table->decimal('total_payable_amount', 10, 2)->nullable();
            $table->integer('total_installments_paid')->default(0);
            $table->date('account_closing_date')->nullable();
            $table->decimal('interest_payable', 10, 2)->nullable();
            $table->decimal('open_interest', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_depo_accounts');
    }
};