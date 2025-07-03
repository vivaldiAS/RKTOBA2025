<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('checkouts')){
            Schema::create('checkouts', function (Blueprint $table) {
                $table->id('checkout_id');
                $table->unsignedBigInteger('user_id');
                $table->text('catatan')->nullable();
                $table->timestampsTz($precision = 0);
                
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
        Schema::dropIfExists('checkouts');
    }
}
