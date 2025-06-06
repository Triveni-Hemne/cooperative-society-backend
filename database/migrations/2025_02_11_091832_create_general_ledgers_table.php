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
        Schema::create('general_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_ledger_id')->nullable()->constrained('general_ledgers')->onDelete('cascade');
            $table->string('ledger_no', 50)->unique();
            $table->string('name', 100);
            $table->decimal('balance', 12, 2)->default(0.00);
            $table->enum('balance_type', ['Credit', 'Debit']);
            $table->decimal('open_balance', 12, 2)->default(0.00);
            $table->enum('open_balance_type', ['Credit', 'Debit']);
            $table->decimal('min_balance', 12, 2)->default(0.00);
            $table->enum('min_balance_type', ['Credit', 'Debit'])->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->boolean('add_interest_to_balance')->default(false);
            $table->date('open_date')->nullable();
            $table->decimal('penal_rate', 5, 2)->default(0.00)->nullable();
            $table->enum('gl_type', ['Society', 'Store']);
            $table->boolean('cd_ratio')->nullable()->default(false);
            $table->enum('group', ['Deposit', 'Loan', 'Bank', 'General', 'Funds','Share '])->nullable();
            $table->enum('type', ['Saving Deposits', 'Recurring Deposits', 'Current Deposits', 'Fixed Deposits', 'Monthly Deposits']);
            $table->string('interest_type', 50);
            $table->boolean('subsidiary')->default(false);
            $table->boolean('demand')->default(false);
            $table->boolean('send_sms')->default(false);
            $table->string('item_of', 255)->nullable();
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_ledgers');
    }
};