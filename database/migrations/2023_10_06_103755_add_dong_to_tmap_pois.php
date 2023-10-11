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
        Schema::table('tmap_pois', function (Blueprint $table) {
            $table->string('sido_code',2)->nullable()->after('crdnt');
			$table->string('legalDongCode',11)->nullable()->after('sido_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tmap_pois', function (Blueprint $table) {
            $table->dropColumn('sido_code');
			$table->dropColumn('legalDongCode');
        });
    }
};
