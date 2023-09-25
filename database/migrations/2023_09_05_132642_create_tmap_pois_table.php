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
	
        Schema::create('tmap_pois', function (Blueprint $table) {
			$table->unsignedBigInteger('pkey')->primary();
			$table->unsignedBigInteger('id');
			$table->string('name');
			$table->string('telno',50)->nullable();
			$table->string('frontLon',15);
			$table->string('frontLat',15);
			$table->point('crdnt',4326);
			$table->string('zipCode',6)->nullable();
			$table->string('upperAddrName',40)->nullable();
			$table->string('middleAddrName',40)->nullable();
			$table->string('lowerAddrName',80)->nullable();
			$table->string('detailAddrName')->nullable();
			$table->string('mlClass',10)->nullable();
			$table->string('firstNo',10)->nullable();
			$table->string('secondNo',10)->nullable();
			$table->string('roadName',80)->nullable();
			$table->string('firstBuildNo',10)->nullable();
			$table->string('secondBuildNo',10)->nullable();
			$table->json('poiobj');
            $table->timestamps();
        });
		\DB::statement("CREATE SPATIAL INDEX `crdnt_index` ON tmap_pois (crdnt);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmap_pois');
    }
};