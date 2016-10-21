<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateReminderToTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('tasks', function(Blueprint $table)
        {
            $table->dateTime('notification_reminder_date');
            $table->string('notification_reminder_time');       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('notification_reminder_date');
            $table->dropColumn('notification_reminder_time');
        });
    }
}
