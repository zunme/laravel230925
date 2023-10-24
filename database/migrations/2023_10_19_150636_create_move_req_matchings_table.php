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
        Schema::create('move_req_matchings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('move_request_id')->index();
            $table->unsignedBigInteger('partner_id');
            $table->enum('notied',['N','P','Y'])->default('N');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('move_req_matchings');
    }
};
