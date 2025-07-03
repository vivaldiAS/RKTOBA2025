<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('wishlists')){
            Schema::create('wishlists', function (Blueprint $table) {
                $table->id('wishlist_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
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
        Schema::dropIfExists('wishlists');
    }
}
