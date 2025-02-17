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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_code', 50)->unique();
            $table->foreignId('designation_id')->constrained('designations')->onDelete('cascade');
            $table->decimal('salary', 10, 2)->default(0);
            $table->decimal('other_allowance', 10, 2)->nullable();
            $table->foreignId('division_id')->constrained('divisions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('subdivision_id')->nullable()->constrained('subdivisions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('center_id')->nullable()->constrained('centers')->onUpdate('cascade')->onDelete('cascade');
            $table->date('joining_date');
            $table->date('transfer_date')->nullable();
            $table->date('retirement_date')->nullable();
            $table->string('gpf_no', 50)->unique()->nullable();
            $table->decimal('hra', 10, 2)->nullable();
            $table->decimal('da', 10, 2)->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Retired'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};