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
        Schema::create('gold_loan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('member_loan_accounts')->onDelete('cascade');
            $table->decimal('gold_weight', 10, 2)->comment('Weight in grams');
            $table->enum('gold_purity', ['18K', '22K', '24K']);
            $table->decimal('market_value', 15, 2)->comment('Value based on purity and weight');
            $table->date('pledged_date');
            $table->enum('release_status', ['Pledged', 'Released'])->default('Pledged');
            $table->date('release_date')->nullable();
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_loan_details');
    }
};