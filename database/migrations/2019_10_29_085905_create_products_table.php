<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product_name');
            $table->mediumText('description');
            $table->float('price', 10, 2);
            $table->integer('quantity');
            $table->unsignedBigInteger('products_type_id_foreign');
            $table->unsignedBigInteger('products_user_id_foreign');
            $table->foreign('products_type_id_foreign')->references('id')->on('types');
            $table->foreign('products_user_id_foreign')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
