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
        Schema::create('partner_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('partner_id');
            $table->tinyInteger('avail_siCode');
            $table->tinyInteger('avail_sigunguCode')->nullable();
            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_areas');
    }
};
