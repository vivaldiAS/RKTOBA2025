<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_specifications')){
            Schema::create('product_specifications', function (Blueprint $table) {
                $table->id('product_specification_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('specification_id');
                
                $table->foreign('product_id')->references('product_id')->on('products');
                $table->foreign('specification_id')->references('specification_id')->on('specifications');
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
        Schema::dropIfExists('product_specifications');
    }
}
