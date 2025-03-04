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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 50)->unique();
            $table->string('name', 255)->unique();
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->integer('age');
            $table->date('date_of_joining')->nullable();
            $table->string('religion', 100)->nullable();
            $table->enum('category', ['ST', 'OBC', 'General', 'NT']);
            $table->foreignId('subcaste_id')->nullable()->constrained('subcastes')->onDelete('set null');
            $table->string('caste', 100);
            $table->string('m_reg_no', 50)->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};