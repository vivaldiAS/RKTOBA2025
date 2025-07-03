<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignServiceBookingIdToServicePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_purchases', function (Blueprint $table) {
            $table->unsignedBigInteger('service_booking_id');

            $table->foreign('service_booking_id')->references('id')->on('service_booking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_purchases', function (Blueprint $table) {
            $table->dropColumn('service_booking_id');
        });
    }
}
