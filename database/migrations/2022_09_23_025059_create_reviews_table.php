<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('reviews')){
            Schema::create('reviews', function (Blueprint $table) {
                $table->id('review_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('nilai_review');
                $table->text('isi_review');
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
        Schema::dropIfExists('reviews');
    }
}
