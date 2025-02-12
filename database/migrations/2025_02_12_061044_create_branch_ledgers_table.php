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
        Schema::create('branch_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('branch_code', 20)->unique();
            $table->foreignId('gl_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->date('open_date')->notNull();
            $table->decimal('open_balance', 12, 2)->notNull();
            $table->decimal('balance', 12, 2)->notNull();
            $table->enum('balance_type', ['Credit', 'Debit'])->notNull();
            $table->enum('item_type', ['Asset', 'Liability', 'Income', 'Expense'])->notNull();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_ledgers');
    }
};