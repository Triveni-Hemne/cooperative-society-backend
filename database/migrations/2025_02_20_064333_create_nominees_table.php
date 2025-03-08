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
            $table->string('name', 255);
            $table->string('naav', 255);
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('relation', 50);
            $table->string('nominee_image', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('marathi_address', 255)->nullable();
            $table->string('adhar_no', 20)->nullable();
            $table->timestamps();
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