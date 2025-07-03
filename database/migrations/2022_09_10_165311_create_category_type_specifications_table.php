<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTypeSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('category_type_specifications')){
            Schema::create('category_type_specifications', function (Blueprint $table) {
                $table->id('category_type_specification_id');
                $table->unsignedBigInteger('category_id');
                $table->unsignedBigInteger('specification_type_id');
                
                $table->foreign('category_id')->references('category_id')->on('categories');
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
        Schema::dropIfExists('category_type_specifications');
    }
}
