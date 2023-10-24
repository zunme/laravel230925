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
            $table->enum('use_front',['N','Y'])->default('N')->after('noti');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('move_requests', function (Blueprint $table) {
            $table->dropColumn('use_front');
        });
    }
};
