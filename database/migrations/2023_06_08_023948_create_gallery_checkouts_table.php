<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_checkouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id');
            $table->unsignedBigInteger('transaction_id');
            $table->bigInteger('quantity');
            $table->timestamps();

            $table->foreign('gallery_id')
                ->references('id')
                ->on('galleries');

            $table->foreign('transaction_id')
                ->references('id')
                ->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_checkouts');
    }
}
