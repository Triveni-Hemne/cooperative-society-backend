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
       Schema::table('agents', function (Blueprint $table) {
            // --- Add New Fields ---
            $table->string('name')->nullable()->after('agent_code');
            $table->string('email')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->date('joining_date')->nullable()->after('address');
            $table->date('resignation_date')->nullable()->after('joining_date');
            $table->unsignedBigInteger('branch_id')->nullable()->after('resignation_date');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            
            $table->foreignId('created_by')->nullable()->after('status')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();

            // --- Correct the wrong spelling column ---
            if (Schema::hasColumn('agents', 'commition_rate')) {
                $table->renameColumn('commition_rate', 'commission_rate');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'email',
                'phone',
                'address',
                'joining_date',
                'resignation_date',
                'created_by',
                'updated_by',
                'branch_id'
            ]);

            // Reverse rename back commission_rate if needed
            if (Schema::hasColumn('agents', 'commission_rate')) {
                $table->renameColumn('commission_rate', 'commition_rate');
            }
        });
    }
};