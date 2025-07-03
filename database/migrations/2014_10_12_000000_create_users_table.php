<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                // $table->text('name')->nullable();
                // $table->string('no_WA')->nullable();
                // $table->string('no_HP')->nullable();
                $table->boolean('is_admin')->nullable();
                $table->boolean('is_banned')->nullable();
                $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
