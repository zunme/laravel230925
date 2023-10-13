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
        Schema::create('lunars', function (Blueprint $table) {
            $table->integer('id')->primary();
			$table->char('solYear',4);
			$table->char('solMonth',2);
			$table->char('solDay',2);
			$table->string('solWeek',4);
			$table->string('solLeapyear',10)->nullable();
			$table->integer('solJd')->nullable();
			
			$table->char('lunYear',4);
			$table->char('lunMonth',2);
			$table->tinyInteger('lunDay')->index();
			$table->char('lunNday',2);
			$table->string('lunLeapmonth',10)->nullable();
			
			$table->string('lunIljin',20)->nullable();
			$table->string('lunSecha',20)->nullable();
			$table->string('lunWolgeon',20)->nullable();
			
			$table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lunars');
    }
};
