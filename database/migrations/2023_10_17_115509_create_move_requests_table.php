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
        Schema::create('move_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('tel',20)->nullable();
            $table->string('name',20)->nullable();
            $table->enum('req_status',['None','Ready','Matching','Done'])->default('Ready');
            $table->tinyInteger('move_type')->nullable();
            $table->date('move_date');

            $table->string('from_zip',6)->nullable();
            $table->string('from_address')->nullable();
            $table->string('from_floor',10)->nullable();
            $table->tinyInteger('from_siCode')->nullable()->index();
            $table->string('from_sido',40)->nullable();
            $table->smallInteger('from_sigunguCode')->nullable();
            $table->string('from_sigungu',60)->nullable();
            
            $table->string('to_zip',6)->nullable();
            $table->string('to_address')->nullable();
            $table->string('to_floor',10)->nullable();
            $table->tinyInteger('to_siCode')->nullable();
            $table->string('to_sido',40)->nullable();
            $table->smallInteger('to_sigunguCode')->nullable();
            $table->string('to_sigungu',60)->nullable();

            $table->enum('keep',['N','Y'])->default('N');
            $table->enum('noty',['N','P','Y'])->default('N');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('move_requests');
    }
};
