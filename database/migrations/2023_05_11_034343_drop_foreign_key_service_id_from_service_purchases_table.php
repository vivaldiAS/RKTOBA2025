<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyServiceIdFromServicePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_purchases', function (Blueprint $table) {
            $table->dropForeign('service_purchases_service_id_foreign');
            $table->dropColumn('service_id');
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
            //
        });
    }
}
