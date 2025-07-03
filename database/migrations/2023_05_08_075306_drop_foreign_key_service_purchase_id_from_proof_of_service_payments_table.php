<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyServicePurchaseIdFromProofOfServicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proof_of_service_payments', function (Blueprint $table) {
            $table->dropForeign('proof_of_service_payments_service_purchase_id_foreign');
            $table->dropColumn('service_purchase_id');
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
            $table->unsignedBigInteger('service_purchase_id');
            $table->foreign('service_purchase_id')->references('service_purchase_id')->on('service_purchases')->onDelete('cascade');
        });
    }
}
