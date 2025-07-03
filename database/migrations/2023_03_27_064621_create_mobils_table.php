<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('nama');
            $table->string('nomor_polisi');
            $table->string('warna');
            $table->string("mode_transmisi");
            $table->string("tipe_driver");
            $table->text("lokasi");
            $table->integer('kapasitas_penumpang');
            $table->integer('harga_sewa_per_hari');
            $table->integer('stok')->default(1);
            $table->text('gambar');
            $table->timestamps();
            $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobils');
    }
}
