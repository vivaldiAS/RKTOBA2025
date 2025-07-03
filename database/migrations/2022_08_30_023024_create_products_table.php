<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('products')){
            Schema::create('products', function (Blueprint $table) {
                $table->id('product_id');
                $table->unsignedBigInteger('merchant_id');
                $table->unsignedBigInteger('category_id');
                $table->string('product_name');
                $table->text('product_description');
                $table->unsignedBigInteger('price');
                $table->integer('heavy');
                $table->string('type')->nullable();
                $table->boolean('is_deleted');
                $table->timestamps();

                $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
                $table->foreign('category_id')->references('category_id')->on('categories');
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
        Schema::dropIfExists('products');
    }
}
