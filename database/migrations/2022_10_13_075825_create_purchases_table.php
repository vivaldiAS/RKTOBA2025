<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('purchases')){
            Schema::create('purchases', function (Blueprint $table) {
                $table->id('purchase_id');
                $table->string('kode_pembelian')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('checkout_id');
                $table->string('alamat_purchase')->nullable();
                $table->unsignedBigInteger('harga_pembelian')->nullable();
                $table->unsignedBigInteger('potongan_pembelian')->nullable();
                $table->string('status_pembelian');
                $table->string('no_resi')->nullable();
                $table->string('courier_code')->nullable();
                $table->string('service')->nullable();
                $table->unsignedBigInteger('ongkir');
                $table->boolean('is_cancelled');
                $table->timestampsTz($precision = 0);

                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('checkout_id')->references('checkout_id')->on('checkouts');
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
        Schema::dropIfExists('purchases');
    }
}
