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
        Schema::table('members', function (Blueprint $table) {
            $table->foreignId('member_branch_id')->nullable()->constrained('branches')->onDelete('set null')->after('category_id');
            $table->string('images', 255)->nullable()->after('member_branch_id');;
            // $table->foreignId('designation_id')->nullable()->constrained('designations')->onDelete('set null')->after('adhar_no');
            // $table->string('cpf_no', 255)->nullable()->after('designation_id');
            $table->foreignId('division_id')->nullable()->constrained('divisions')->onDelete('set null')->after('member_branch_id');
            $table->foreignId('subdivision_id')->nullable()->constrained('subdivisions')->onDelete('set null')->after('division_id');
            $table->date('membership_date')->nullable()->after('subdivision_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('members_designation_id_foreign');
            $table->dropForeign('members_member_branch_id_foreign');
            $table->dropForeign('members_member_division_id_foreign');
            $table->dropForeign('members_member_subdivision_id_foreign');
            $table->dropColumn(['member_branch_id','images','designation_id','cpf_no','division_id','subdivision_id','membership_date']);   
        });
    }
};