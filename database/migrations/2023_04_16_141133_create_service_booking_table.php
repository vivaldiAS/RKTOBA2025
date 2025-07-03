<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('service_id');
            $table->string('address');
            $table->string('phone_number');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('notes');
            $table->enum('status', ['waiting', 'approved', 'declined', 'done']);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_booking');
    }
}
