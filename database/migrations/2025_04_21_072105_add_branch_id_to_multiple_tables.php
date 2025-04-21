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
        Schema::table('multiple_tables', function (Blueprint $table) {
            Schema::table('members', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('name');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });

            Schema::table('transfer_entries', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('id');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });

            Schema::table('branch_ledgers', function (Blueprint $table) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('id');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multiple_tables', function (Blueprint $table) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
            });

            Schema::table('transfer_entries', function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
            });

            Schema::table('branch_ledgers', function (Blueprint $table) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
            });
        });
    }
};