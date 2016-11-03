<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsIngresosToClientsTable extends Migration
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
            $table->double('income');
            $table->tinyInteger('debts')->default(0);
            $table->double('debts_amount')->default(0);
            $table->string('prima')->nullable();
            $table->tinyInteger('potencial')->default(0);
            
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
            $table->dropColumn('income');
            $table->dropColumn('debts');
            $table->dropColumn('prima');
            $table->dropColumn('potencial');
        });
    }
}
