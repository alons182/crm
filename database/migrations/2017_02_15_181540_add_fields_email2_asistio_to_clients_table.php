<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsEmail2AsistioToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('clients', function(Blueprint $table)
        {
            $table->string('email2')->nullable(); 
            $table->tinyInteger('cita')->default(0);
           
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('email2');
            $table->dropColumn('cita');
        });
    }
}
