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
        Schema::table('day_ends', function (Blueprint $table) {
            
            $table->unsignedBigInteger('branch_id')->nullable()->after('id');
            $table->unsignedBigInteger('user_id')->after('branch_id');
            $table->decimal('closing_cash_balance', 15, 2)->default(0)->after('user_id');
            $table->decimal('total_receipts', 15, 2)->default(0)->after('closing_cash_balance');
            $table->decimal('total_payments', 15, 2)->default(0)->after('total_receipts');
            $table->decimal('system_closing_balance', 15, 2)->default(0)->after('total_payments');
            $table->decimal('difference_amount', 15, 2)->default(0)->after('system_closing_balance');
            $table->boolean('is_day_closed')->default(false)->after('difference_amount');
            $table->text('remarks')->nullable()->after('is_day_closed');
            $table->unsignedBigInteger('created_by')->nullable()->after('remarks');
             $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            if (Schema::hasColumn('day_ends', 'date')) {
                $table->unique(['date', 'branch_id'], 'day_ends_date_branch_unique');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('day_ends', function (Blueprint $table) {
            if (Schema::hasColumn('day_ends', 'created_by')) {
                $table->dropForeign(['created_by']);
            }

            if (Schema::hasColumn('day_ends', 'date')) {
                $table->dropUnique('day_ends_date_branch_unique');
            }

            $table->dropColumn([
                'created_by',
                'branch_id',
                'user_id',
                'closing_cash_balance',
                'total_receipts',
                'total_payments',
                'system_closing_balance',
                'difference_amount',
                'is_day_closed',
                'remarks',
            ]);
        });
    }
};