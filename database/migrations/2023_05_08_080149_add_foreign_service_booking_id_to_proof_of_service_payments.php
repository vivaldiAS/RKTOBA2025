<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignServiceBookingIdToProofOfServicePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proof_of_service_payments', function (Blueprint $table) {
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
        Schema::table('proof_of_service_payments', function (Blueprint $table) {
            $table->dropColumn('service_booking_id');
        });
    }
}
