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
        Schema::create('holidays', function (Blueprint $table) {
            $table->integer('locdate')->primary();
			$table->string('dateKind', 3)->nullable();
			$table->string('dateName', 50)->nullable();
			$table->string('isHoliday', 2)->nullable();
			$table->integer('seq')->nullable();
			$table->timestamp('last_update')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
			//$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};