<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('profiles')){
            Schema::create('profiles', function (Blueprint $table) {
                $table->id('profile_id');
                $table->unsignedBigInteger('user_id');
                $table->string('name');
                // $table->string('email')->unique();
                // $table->text('address');
                // $table->string('password');
                $table->string('no_hp');
                $table->date('birthday');
                $table->string('gender', 1);
                // $table->string('photo');
                $table->softDeletes('deleted_at');
                $table->timestampsTz($precision = 0);

                $table->foreign('user_id')->references('id')->on('users');
                // $table->foreign('email')->references('email')->on('users');
                // $table->foreign('password')->references('password')->on('users');
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
        Schema::dropIfExists('profiles');
    }
}
