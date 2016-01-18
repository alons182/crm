<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->dateTime('notification_date');
            $table->string('notification_time');       
            $table->integer('notification_reminder');
            $table->enum('notification_choices_time', ['mins', 'hours','days','weeks']);
            $table->string('notification_to');   
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
        /*Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');
            $table->dateTime('date');      
            $table->integer('time');
            $table->enum('choices_time', ['mins', 'hours','days','weeks']);
            $table->timestamps();
        });*/

         /*Schema::create('task_user', function (Blueprint $table) {
            $table->integer('task_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');

            $table->primary(['task_id', 'user_id']);
        });

        Schema::create('client_task', function (Blueprint $table) {
            $table->integer('task_id')->unsigned();
            $table->integer('client_id')->unsigned();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');

            $table->primary(['task_id', 'client_id']);
        }); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         /*Schema::drop('task_user');
         Schema::drop('client_task');*/
         //Schema::drop('notifications');
         Schema::drop('tasks');
    }
}
