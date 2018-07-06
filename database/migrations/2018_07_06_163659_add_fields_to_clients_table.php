<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('apellido1')->nullable();
            $table->string('apellido2')->nullable();
            $table->dateTime('birthdate');
            $table->string('gender')->nullable();
            $table->text('interesado')->nullable();

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
            $table->dropColumn('apellido1');
            $table->dropColumn('apellido2');
            $table->dropColumn('gender');
            $table->dropColumn('interesado');

        });
    }
}
