<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_address')){
            Schema::create('user_address', function (Blueprint $table) {
                $table->id('user_address_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('province_id');
                $table->unsignedBigInteger('city_id');
                $table->unsignedBigInteger('subdistrict_id');
                $table->string('user_street_address');
                $table->boolean('is_deleted');
                
                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_address');
    }
}
