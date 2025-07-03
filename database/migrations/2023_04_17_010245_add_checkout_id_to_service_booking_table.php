<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckoutIdToServiceBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_booking', function (Blueprint $table) {
            $table->unsignedBigInteger('checkout_id');

            $table->foreign('checkout_id')->references('checkout_id')->on('checkouts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_booking', function (Blueprint $table) {
            $table->dropColumn('checkout_id');
        });
    }
}
