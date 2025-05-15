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
        Schema::create('transfer_entries', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ['Credit', 'Debit', 'Journal'])->notNull();
            $table->date('date')->notNull();
            $table->string('receipt_id', 50)->unique()->nullable();
            $table->string('payment_id', 50)->unique()->nullable();
            $table->foreignId('ledger_id')->constrained('general_ledgers')->onDelete('cascade');
            $table->decimal('opening_balance', 12, 2)->notNull();
            $table->decimal('current_balance', 12, 2)->notNull();
            $table->text('narration')->nullable();
            $table->text('m_narration')->nullable();
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_entries');
    }
};