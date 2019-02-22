<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsNuevosToClientsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('estado_civil')->nullable();
            $table->string('conyuge')->nullable();
            $table->string('family_members')->nullable();
            $table->tinyInteger('pets')->default(0);
            $table->string('profesion')->nullable();
            $table->string('residencia')->nullable();
            $table->string('motivo_compra')->nullable();
            
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
            $table->dropColumn('estado_civil');
            $table->dropColumn('conyuge');
            $table->dropColumn('family_members');
            $table->dropColumn('pets');
            $table->dropColumn('profesion');
            $table->dropColumn('residencia');
            $table->dropColumn('motivo_compra');

        });
    }
}
