<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_rentals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pemesanan');
            $table->date('tanggal_mulai_sewa');
            $table->date('tanggal_akhir_sewa');
            $table->integer('jumlah_hari_sewa');
            $table->integer('total_harga');
            $table->boolean('status_pembayaran')->default(false);
            $table->foreignId('user_id')->constrained();
            $table->foreignId('mobil_id')->constrained();
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
        Schema::dropIfExists('pemesanan_rentals');
    }
}
