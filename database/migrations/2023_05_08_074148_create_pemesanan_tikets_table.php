<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemesananTiketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanan_tikets', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pemesanan');
            $table->integer('jumlah_anak');
            $table->integer('jumlah_dewasa');
            $table->integer('total_harga');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('tiket_experience_id')->constrained();
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
