<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_carts', function (Blueprint $table) {
            $table->id('cart_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('jumlah_masuk_keranjang')->default(1);
            $table->timestampsTz($precision = 0);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_carts');
    }
}
