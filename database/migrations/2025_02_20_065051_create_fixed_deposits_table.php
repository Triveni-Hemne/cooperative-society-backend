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
        Schema::create('fixed_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_account_id')->constrained('member_depo_accounts')->onDelete('cascade');
            $table->integer('fd_term_months');
            $table->decimal('maturity_amount', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_deposits');
    }
};