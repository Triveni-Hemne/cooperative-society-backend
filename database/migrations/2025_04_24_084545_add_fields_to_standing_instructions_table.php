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
        Schema::table('standing_instructions', function (Blueprint $table) {
           $table->unsignedBigInteger('created_by')->nullable()->after('amount');
           $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
           $table->unsignedBigInteger('branch_id')->nullable()->after('created_by');
           $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('standing_instructions', function (Blueprint $table) {
              $table->dropForeign(['created_by','branch_id']);
            $table->dropColumn(['created_by','branch_id']);
        });
    }
};