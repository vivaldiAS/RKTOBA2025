<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProofOfPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('proof_of_payments')){
            Schema::create('proof_of_payments', function (Blueprint $table) {
                $table->id('proof_of_payment_id');
                $table->unsignedBigInteger('purchase_id');
                $table->string('proof_of_payment_image');
                
                $table->foreign('purchase_id')->references('purchase_id')->on('purchases');
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
        Schema::dropIfExists('proof_of_payments');
    }
}