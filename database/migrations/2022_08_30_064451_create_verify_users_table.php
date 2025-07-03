<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('verify_users')){
            Schema::create('verify_users', function (Blueprint $table) {
                $table->id('verify_id');
                $table->unsignedBigInteger('user_id');
                // $table->tinyInteger('verified');
                $table->string('foto_ktp');
                $table->string('ktp_dan_selfie');
                $table->boolean('is_verified')->nullable();
                // $table->rememberToken();
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
        Schema::dropIfExists('verify_users');
    }
}
