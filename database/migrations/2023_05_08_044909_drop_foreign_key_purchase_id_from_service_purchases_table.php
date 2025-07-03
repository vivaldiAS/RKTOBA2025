<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyPurchaseIdFromServicePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_purchases', function (Blueprint $table) {
            $table->dropForeign('service_purchases_purchase_id_foreign');
            $table->dropColumn('purchase_id');
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
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('purchase_id')->on('purchases')->onDelete('cascade');
        });
    }
}
