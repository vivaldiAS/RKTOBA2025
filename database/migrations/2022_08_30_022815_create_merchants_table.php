<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('merchants')){
            Schema::create('merchants', function (Blueprint $table) {
                $table->id('merchant_id');
                $table->unsignedBigInteger('user_id');
                $table->string('nama_merchant');
                $table->text('deskripsi_toko');
                $table->string('kontak_toko');
                $table->string('foto_merchant');
                $table->boolean('is_verified')->nullable();
                $table->boolean('on_vacation')->nullable();
                $table->timestampsTz($precision = 0);

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
        Schema::dropIfExists('merchants');
    }
}
