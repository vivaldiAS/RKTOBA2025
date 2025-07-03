<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('specifications')){
            Schema::create('specifications', function (Blueprint $table) {
                $table->id('specification_id');
                $table->unsignedBigInteger('specification_type_id');
                $table->string('nama_spesifikasi');
                
                $table->foreign('specification_type_id')->references('specification_type_id')->on('specification_types');
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
        Schema::dropIfExists('specifications');
    }
}
