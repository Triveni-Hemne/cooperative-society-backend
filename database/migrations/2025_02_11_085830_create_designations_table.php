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
        Schema::create('designations', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->unique();
            $table->string('naav',100)->nullable();
            $table->text('description')->nullable();
            $table->foreignId('division_id')->constrained('divisions')->onDelete('cascade');
            $table->foreignId('subdivision_id')->constrained('subdivisions')->onDelete('cascade');
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designations');
    }
};