<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->string('name');
            $table->double('price');
            $table->string('province');
            $table->string('address');
            $table->string('size')->nullable();
            $table->string('construction')->nullable();
            $table->integer('rooms');
            $table->string('owner');
            $table->string('owner_phone1');
            $table->string('owner_phone2')->nullable();
            $table->string('owner_email');
            $table->string('project')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('client_property', function (Blueprint $table) {
            $table->integer('property_id')->unsigned();
            $table->integer('client_id')->unsigned();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');

            $table->primary(['property_id', 'client_id']);
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('client_property');
         Schema::drop('properties');
    }
}
