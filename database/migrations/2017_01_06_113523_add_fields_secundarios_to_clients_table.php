<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsSecundariosToClientsTable extends Migration
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
            $table->integer('bank')->default(0);
            $table->integer('bank2')->default(0);
            $table->integer('project')->unsigned()->index()->default(0);
            $table->dateTime('formalization_date');
            $table->dateTime('reservation_date');
            $table->dateTime('option_date');
            $table->dateTime('expedient_date');
            $table->string('credit'); 
            $table->dateTime('avaluo_date');
            $table->tinyInteger('documents')->default(1);
            $table->text('documents_text')->nullable();
            $table->tinyInteger('fiador')->default(0);
            $table->text('fiador_text')->nullable();  
           
            
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
            $table->dropColumn('bank');
            $table->dropColumn('bank2');
            $table->dropColumn('project');
            $table->dropColumn('formalization_date');
            $table->dropColumn('reservation_date');
            $table->dropColumn('option_date');
            $table->dropColumn('expedient_date');
            $table->dropColumn('credit');
            $table->dropColumn('avaluo_date');
            $table->dropColumn('documents');
            $table->dropColumn('documents_text');
            $table->dropColumn('fiador');
            $table->dropColumn('fiador_text');
            
        });
    }
}
