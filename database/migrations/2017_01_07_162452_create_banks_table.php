<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bank_id')->unsigned();
            $table->foreign('bank_id')
                  ->references('id')
                  ->on('banks')
                  ->onDelete('cascade');
                  
            $table->string('name');

            $table->timestamps();
        });

        Schema::create('client_requirement', function (Blueprint $table) {
            $table->integer('requirement_id')->unsigned();
            $table->integer('client_id')->unsigned();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('requirement_id')
                  ->references('id')
                  ->on('requirements')
                  ->onDelete('cascade');

            $table->primary(['requirement_id', 'client_id']);
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_requirement');
        Schema::drop('requirements');
        Schema::drop('banks');
    }
}
