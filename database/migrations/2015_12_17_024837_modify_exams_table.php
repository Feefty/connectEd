<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exams', function(Blueprint $t)
        {
            $t->dropColumn('date_start', 'date_end');
            $t->dateTime('start');
            $t->dateTime('end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::talbe('exams', function(Blueprint $t)
        {
            $t->date('date_start');
            $t->date('date_end');
        });
    }
}
