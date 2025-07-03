<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_purchases', function (Blueprint $table) {
            $table->id('service_purchase_id');
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('amount');
            $table->integer('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes');
            
            $table->foreign('purchase_id')->references('purchase_id')->on('purchases');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_purchases');
    }
}
