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
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('acc_no', 50)->unique();
            $table->string('name', 255);
            $table->date('ac_start_date');
            $table->decimal('open_balance', 10, 2);
            $table->enum('purpose', ['Agriculture', 'Construction', 'Cottage', 'SSI Unit', 'Dairy']);
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('balance', 10, 2);
            $table->tinyInteger('priority')->default(0);
            $table->decimal('loan_amount', 10, 2);
            $table->foreignId('guarantor1_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('guarantor2_id')->nullable()->constrained('members')->onDelete('set null');
            $table->foreignId('guarantor3_id')->nullable()->constrained('members')->onDelete('set null');
            $table->boolean('close_flag')->default(0);
            $table->boolean('add_to_demand')->default(0);
            $table->boolean('is_loss_asset')->default(0);
            $table->boolean('case_flag')->default(0);
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