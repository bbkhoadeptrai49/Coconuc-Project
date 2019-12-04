<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinceDistrictWardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province_district_ward', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('province_name');
            $table->bigInteger('province_id');
            $table->bigInteger('province_code');
            $table->string('district_name');
            $table->bigInteger('district_code');
            $table->bigInteger('district_id');
            $table->string('ward_name');
            $table->bigInteger('code');
            $table->bigInteger('ward_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('province_district_ward');
    }
}
