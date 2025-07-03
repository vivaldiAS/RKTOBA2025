<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_images')){
            Schema::create('product_images', function (Blueprint $table) {
                $table->id('product_image_id');
                $table->unsignedBigInteger('product_id');
                $table->string('product_image_name');
                
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
        Schema::dropIfExists('product_images');
    }
}
