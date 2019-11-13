<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('carts')) {
            Schema::create('carts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('product_name');
                $table->float('price');
                $table->string('providers');
                $table->string('url');
                $table->integer('quantity');
                $table->unsignedBigInteger('carts_user_id_foreign');
                $table->unsignedBigInteger('carts_product_id_foreign');
                $table->integer('status');
                $table->foreign('carts_user_id_foreign')->references('id')->on('users');
                $table->foreign('carts_product_id_foreign')->references('id')->on('products');
                // $table->timestamps();
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
        Schema::dropIfExists('carts');
    }
}
