<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldBloqueToPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('properties', function(Blueprint $table)
        {

            $table->string('block')->nullable(); 
            $table->dateTime('completed_house_date');
            $table->dateTime('delivery_date');
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('properties', function(Blueprint $table)
        {
    
            $table->dropColumn('block');
            $table->dropColumn('completed_house_date');
            $table->dropColumn('delivery_date');
            
         });
    }
}
