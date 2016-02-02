<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ide');
            $table->string('fullname');
            $table->string('company');
            $table->string('job')->nullable();
            $table->string('email');
            $table->string('web')->nullable();
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            $table->string('phone4')->nullable();
            $table->string('referred');
            $table->string('referred_others')->nullable();
            $table->text('address')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('client_user', function (Blueprint $table) {
            $table->integer('client_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->primary(['client_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('client_user');
        Schema::drop('clients');
    }
}
