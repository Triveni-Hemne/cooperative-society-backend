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
        Schema::create('personal_demand_posting_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('posting_id');
            $table->string('gl_code')->nullable();
            $table->string('gl_name')->nullable();
            $table->string('account_code')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->decimal('balance', 12, 2)->nullable();
            $table->timestamps();

            // Foreign Key
            $table->foreign('posting_id')->references('id')->on('personal_demand_postings')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_demand_posting_entries');
    }
};