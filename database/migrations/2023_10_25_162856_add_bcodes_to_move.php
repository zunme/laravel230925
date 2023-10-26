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
        Schema::table('move_requests', function (Blueprint $table) {
            $table->string('from_bcode',10)->nullable()->after('from_sigungu');
            $table->string('to_bcode',10)->nullable()->after('to_sigungu');
            $table->integer('matching_cnt')->nullable()->after('matched_partner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('move_requests', function (Blueprint $table) {
            $table->dropColumn('from_bcode');
            $table->dropColumn('to_bcode');
            $table->dropColumn('matching_cnt');
        });
    }
};
