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
        Schema::create('loan_resolution_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('member_loan_accounts')->onDelete('cascade');
            $table->string('resolution_no', 50)->unique();
            $table->date('resolution_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_resolution_details');
    }
};