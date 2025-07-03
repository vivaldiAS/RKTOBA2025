<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('province_name', 'city_name', 'subdistrict_name')){
            Schema::table("user_address", function (Blueprint $table){
                $table->string("province_name")->nullable()->after('province_id');
                $table->string("city_name")->nullable()->after('city_id');
                $table->string("subdistrict_name")->nullable()->after('subdistrict_id');
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
        if(Schema::hasColumn('province_name', 'city_name', 'subdistrict_name')){
            Schema::table('user_address', function (Blueprint $table){
                $table->dropColumn("province_name");
                $table->dropColumn("city_name");
                $table->dropColumn("subdistrict_name");
            });
        }
    }
}
