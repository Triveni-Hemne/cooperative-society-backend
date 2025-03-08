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
        Schema::create('member_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('bank_name', 255);
            $table->string('branch_name', 255);
            $table->string('bank_account_no', 50)->unique();
            $table->string('ifsc_code', 11);
            $table->string('proof_1_image', 50)->unique()->nullable();
            $table->string('proof_1_no', 50)->unique()->nullable();
            $table->string('proof_1_type', 50)->nullable();
            $table->string('proof_2_image', 50)->unique()->nullable();
            $table->string('proof_2_no', 50)->unique()->nullable();
            $table->string('proof_2_type', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_bank_details');
    }
};