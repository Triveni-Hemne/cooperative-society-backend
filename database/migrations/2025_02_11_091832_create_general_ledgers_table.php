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
            $table->foreignId('schedule_id')->constrained('schedule_ledgers')->onDelete('cascade');
            $table->string('name', 255);
            $table->decimal('balance', 12, 2)->default(0.00);
            $table->decimal('open_balance', 12, 2)->default(0.00);
            $table->decimal('min_amount', 12, 2)->default(0.00);
            $table->boolean('subsidiary')->default(false);
            $table->string('group', 255)->nullable();
            $table->boolean('demand')->default(false);
            $table->enum('type', ['Bank', 'Loan', 'Investment', 'Member', 'Deposit']);
            $table->enum('gl_type', ['Asset', 'Liability', 'Income', 'Expense']);
            $table->string('item_of', 255)->nullable();
            $table->timestamps();
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