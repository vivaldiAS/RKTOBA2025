<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_purchases')){
            Schema::create('product_purchases', function (Blueprint $table) {
                $table->id('product_purchase_id');
                $table->unsignedBigInteger('purchase_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('berat_pembelian_produk')->nullable();
                $table->integer('jumlah_pembelian_produk');
                $table->unsignedBigInteger('harga_pembelian_produk')->nullable();
                
                $table->foreign('purchase_id')->references('purchase_id')->on('purchases');
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
        Schema::dropIfExists('product_purchases');
    }
}
