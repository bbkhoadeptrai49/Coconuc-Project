<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('images')) {
            Schema::create('images', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('images_product_id_foreign');
                $table->string('url');
                $table->foreign('images_product_id_foreign')->references('id')->on('products');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
