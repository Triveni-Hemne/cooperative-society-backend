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
        Schema::table('day_begins', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('id');
            $table->unsignedBigInteger('user_id')->after('branch_id');
            $table->decimal('opening_cash_balance', 15, 2)->default(0)->after('user_id');
            $table->text('remarks')->nullable()->after('opening_cash_balance');
            $table->unsignedBigInteger('created_by')->nullable()->after('remarks');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            
            // Only add the unique constraint if the 'date' column exists
            if (Schema::hasColumn('day_begins', 'date')) {
                $table->unique(['date', 'branch_id'], 'day_begins_date_branch_unique');
            }
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('day_begins', function (Blueprint $table) {
            $table->dropForeign(['created_by','branch_id','user_id']);
            $table->dropUnique('day_begins_date_branch_unique');
            $table->dropColumn(['created_by','branch_id', 'user_id', 'opening_cash_balance', 'remarks']);
        });
    }
};