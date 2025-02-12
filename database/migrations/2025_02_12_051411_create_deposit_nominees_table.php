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
        Schema::create('deposit_nominees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_account_id')->constrained('member_depo_accounts')->onDelete('cascade');
            $table->string('name', 255)->notNull();
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('relation', 100)->notNull();
            $table->string('nominee_image', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_nominees');
    }
};