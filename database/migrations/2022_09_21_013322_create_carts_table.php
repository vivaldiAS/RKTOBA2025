<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('carts')){
            Schema::create('carts', function (Blueprint $table) {
                $table->id('cart_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('jumlah_masuk_keranjang');
                $table->timestampsTz($precision = 0);

                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('product_id')->references('product_id')->on('products');
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
