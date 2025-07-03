<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProofOfServicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proof_of_service_payments', function (Blueprint $table) {
            $table->id();
            $table->string('proof_of_payment_image');
            $table->unsignedBigInteger('service_purchase_id');
            $table->timestamps();

            $table->foreign('service_purchase_id')->references('service_purchase_id')->on('service_purchases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proof_of_service_payments');
    }
}
