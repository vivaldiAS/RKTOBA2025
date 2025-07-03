<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');

            $table->string('product_name');
            $table->text('product_description');
            $table->longText('image');
            $table->unsignedBigInteger('price');
            $table->integer('heavy');

            $table->integer('stok');
            $table->dateTime('expired_at');
            $table->boolean('is_request');
            $table->boolean('is_accepted')->nullable();
            $table->text('alasan_ditolak');
            $table->boolean('in_gallery');

            $table->boolean('is_deleted');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
            $table->foreign('category_id')->references('category_id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
