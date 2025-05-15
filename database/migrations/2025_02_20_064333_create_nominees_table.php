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
        Schema::create('nominees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nominee_id')->nullable()->constrained('members')->onDelete('cascade'); // Nullable to prevent foreign key errors
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('cascade'); //stores id of member if this nominee is of any member
            $table->foreignId('depo_acc_id')->nullable()->constrained('member_depo_accounts')->onDelete('cascade'); // stores id of depo.acc. if this nominee is of depo.acc
            $table->foreignId('loan_acc_id')->nullable()->constrained('member_loan_accounts')->onDelete('cascade'); // stores id of loan.acc. if this nominee is of depo.acc
            $table->string('nominee_name', 255);
            $table->string('nominee_naav', 255)->nullable();
            $table->integer('nominee_age');
            $table->enum('nominee_gender', ['Male', 'Female', 'Other']);
            $table->string('relation', 50);
            $table->string('nominee_image', 255)->nullable();
            $table->string('nominee_address', 255)->nullable();
            $table->string('nominee_marathi_address', 255)->nullable();
            $table->string('nominee_adhar_no', 20)->nullable();
            $table->timestamps();
            $table->softDeletes(); // adds deleted_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nominees');
    }
};