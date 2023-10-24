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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('userid',20)->unique();
            $table->string('email',40)->nullable();
            $table->string('tel', 20)->nullable();
			$table->string('user_from')->nullable();
			$table->string('from_userid')->nullable();
            $table->enum('authtype',['partner','admin'])->default('partner');
            $table->enum('userstatus',['ready','confirmed','penalty','banned'])->default('confirmed');
            $table->integer('total_point')->default('0');
            $table->integer('total_reward')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
