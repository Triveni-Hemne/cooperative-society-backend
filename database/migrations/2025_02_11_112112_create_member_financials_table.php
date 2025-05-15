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
        Schema::create('member_financials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->foreignId('director_id')->nullable()->constrained('users')->nullOnDelete(); // Assuming directors are stored in users table
            $table->decimal('share_amount', 10, 2)->nullable();
            $table->integer('number_of_shares')->nullable();
            $table->decimal('welfare_fund', 10, 2)->nullable();
            $table->string('page_no', 50)->nullable();
            $table->decimal('current_balance', 10, 2)->nullable();
            $table->decimal('monthly_balance', 10, 2)->nullable();
            $table->decimal('dividend_amount', 10, 2)->nullable();
            $table->decimal('monthly_deposit', 10, 2)->nullable();
            $table->string('demand')->nullable();
            $table->enum('type', ['Share', 'Dividend', 'Deposit'])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_financials');
    }
};