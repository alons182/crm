<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldReservationPaidToClientsTable extends Migration
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
            $table->tinyInteger('reservation_paid')->default(0);
            $table->dateTime('cita_date');
           
           
            
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
            $table->dropColumn('reservation_paid');
            $table->dropColumn('cita_date');
          
        });
    }
}
