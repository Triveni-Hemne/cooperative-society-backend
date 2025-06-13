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
            $table->string('emp_code', 50)->nullable()->unique();
            $table->foreignId('designation_id')->nullable()->constrained('designations')->nullOnDelete();
            $table->decimal('salary', 10, 2)->nullable();
            $table->decimal('other_allowance', 10, 2)->nullable();
            $table->foreignId('division_id')->nullable()->constrained('divisions')->nullOnDelete();
            $table->foreignId('subdivision_id')->nullable()->constrained('subdivisions')->nullOnDelete();
            $table->foreignId('center_id')->nullable()->constrained('centers')->nullOnDelete();
            $table->date('joining_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->date('retirement_date')->nullable();
            $table->string('cpf_no', 50)->unique()->nullable();
            $table->decimal('hra', 10, 2)->nullable();
            $table->decimal('da', 10, 2)->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Retired'])->default('Active')->nullable();
            $table->timestamps();
            $table->softDeletes();
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