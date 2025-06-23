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
        Schema::create('personal_demand_postings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('month')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->year('year')->nullable();
            $table->date('posting_date')->nullable();
            $table->boolean('is_transferred')->default(false);
            $table->decimal('total_amount', 12, 2)->default(0.00)->nullable();
            $table->unsignedBigInteger('ledger_id')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->enum('posting_type', ['personal', 'bulk'])->default('personal');
            $table->string('acc_type')->nullable();
            $table->string('cheque_no')->nullable();
            $table->text('narration')->nullable();
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('ledger_id')->references('id')->on('general_ledgers')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_demand_postings');
    }
};