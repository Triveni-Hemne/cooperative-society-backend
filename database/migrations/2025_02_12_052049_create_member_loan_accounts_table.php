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
        Schema::create('member_loan_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('cascade');
            $table->string('images', 255)->nullable();
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->string('acc_no', 50)->unique();
            $table->enum('loan_type', ['Personal Loan', 'Home Loan', 'Auto Loan', 'Business Loan','Gold Loan']);
            $table->string('name', 255);
            $table->date('ac_start_date');
            $table->decimal('open_balance', 10, 2);
            $table->enum('purpose', ['Agriculture', 'Construction', 'Cottage', 'SSI Unit', 'Dairy']);
            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->integer('tenure')->comment('Loan duration in months');
            $table->decimal('emi_amount', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('balance', 10, 2);
            $table->tinyInteger('priority')->default(0);
            $table->decimal('loan_amount', 10, 2);
            $table->enum('collateral_type', ['Gold', 'Property', 'Vehicle', 'None'])->default('None');
            $table->decimal('collateral_value', 15, 2)->default(0.00);
            $table->enum('status', ['Active', 'Closed', 'Defaulted'])->default('Active');
            $table->boolean('add_to_demand')->default(false);
            $table->boolean('is_loss_asset')->default(false);
            $table->boolean('case_flag')->default(false);
            $table->string('page_no', 50)->nullable();
            $table->decimal('interest', 10, 2);
            $table->decimal('postage', 10, 2)->nullable();
            $table->decimal('insurance', 10, 2)->nullable();
            $table->decimal('open_interest', 10, 2)->nullable();
            $table->decimal('penal_interest', 10, 2)->nullable();
            $table->decimal('notice_fee', 10, 2)->nullable();
            $table->date('insurance_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_loan_accounts');
    }
};