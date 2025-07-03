<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingLocalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('shipping_locals')){
            Schema::create('shipping_locals', function (Blueprint $table) {
                $table->id('shipping_local_id');
                $table->unsignedBigInteger('merchant_id');
                $table->unsignedBigInteger('shipping_local_province_id');
                $table->unsignedBigInteger('shipping_local_city_id');
                $table->unsignedBigInteger('shipping_local_subdistrict_id');
                $table->unsignedBigInteger('biaya_jasa');
                
                $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
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
        Schema::dropIfExists('shipping_locals');
    }
}
