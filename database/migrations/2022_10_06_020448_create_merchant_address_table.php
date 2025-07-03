<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if(!Schema::hasTable('merchant_address')){
            Schema::create('merchant_address', function (Blueprint $table) {
                $table->id('merchant_address_id');
                $table->unsignedBigInteger('merchant_id');
                $table->unsignedBigInteger('province_id');
                $table->unsignedBigInteger('city_id');
                $table->unsignedBigInteger('subdistrict_id');
                $table->string('merchant_street_address');
                
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
        Schema::dropIfExists('merchant_address');
    }
}
