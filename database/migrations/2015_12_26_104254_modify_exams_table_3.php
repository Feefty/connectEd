<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyExamsTable3 extends Migration
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
            $t->dropColumn('start', 'end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams', function(Blueprint $t)
        {
            $t->dateTime('start');
            $t->dateTime('end');
        });
    }
}
