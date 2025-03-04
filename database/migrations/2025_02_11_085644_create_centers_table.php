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
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('subdivision_id')->constrained('subdivisions')->onDelete('cascade');
            $table->string('name', 100)->unique();
            $table->string('naav',100)->nullable()->unique();
            $table->text('address')->nullable();
            $table->text('marathi_address')->nullable();
            $table->text('description')->nullable();
            $table->string('marathi_description')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};