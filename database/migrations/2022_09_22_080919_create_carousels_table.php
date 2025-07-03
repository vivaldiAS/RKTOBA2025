<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('carousels')){
            Schema::create('carousels', function (Blueprint $table) {
                $table->id();            
                $table->string('carousel_image');
                $table->string('link_carousel')->nullable();
                $table->boolean('open_in_new_tab');
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
        Schema::dropIfExists('carousels');
    }
}
