<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('vouchers')){
            Schema::create('vouchers', function (Blueprint $table) {
                $table->id('voucher_id');
                $table->string('nama_voucher');
                $table->string('tipe_voucher');
                $table->string('target_kategori')->nullable();
                $table->string('target_metode_pembelian')->nullable();
                $table->integer('potongan');
                $table->integer('minimal_pengambilan');
                $table->integer('maksimal_pemotongan');
                $table->date('tanggal_berlaku');
                $table->date('tanggal_batas_berlaku');
                $table->boolean('is_deleted');
                $table->timestampsTz($precision = 0);
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
        Schema::dropIfExists('vouchers');
    }
}
