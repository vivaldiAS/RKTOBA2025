<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiketExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiket_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id');
            $table->string('nama');
            $table->string('lokasi');
            $table->enum('jenis_tiket', ['museum', 'kolam renang']);
            $table->string('jam_operasional');
            $table->integer('harga_anak');
            $table->integer('harga_dewasa');
            $table->string('gambar');
            $table->foreign('merchant_id')->references('merchant_id')->on('merchants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiket_experiences');
    }
}
