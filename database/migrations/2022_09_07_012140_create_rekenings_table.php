<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('rekenings')){
            Schema::create('rekenings', function (Blueprint $table) {
                $table->id('rekening_id');
                $table->unsignedBigInteger('user_id');
                $table->string('nama_bank');
                $table->string('nomor_rekening');
                $table->string('atas_nama');
                // $table->string('gambar');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('rekenings');
    }
}
