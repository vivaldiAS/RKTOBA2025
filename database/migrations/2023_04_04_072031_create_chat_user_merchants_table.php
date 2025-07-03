<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatUserMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('chat_user_merchants')){
            Schema::create('chat_user_merchants', function (Blueprint $table) {
                $table->id('chat_user_merchant_id');
                $table->unsignedBigInteger('id_from');
                $table->unsignedBigInteger('id_to');
                $table->string('pengirim');
                $table->text('isi_chat');
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
        Schema::dropIfExists('chat_user_merchants');
    }
}
