<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id('service_id');
            $table->unsignedBigInteger('merchant_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('service_name');
            $table->text('service_description');
            $table->unsignedBigInteger('price');
            $table->boolean('is_deleted');
            $table->timestamps();
            $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
