<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsPercentToPropertiesTable extends Migration
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
            $table->double('percent')->default(0); 
            $table->double('seller_percent')->default(0); 
            $table->string('office')->nullable(); 
            
           
            
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
            $table->dropColumn('percent');
            $table->dropColumn('seller_percent');
            $table->dropColumn('office');
            
         });
    }
}
