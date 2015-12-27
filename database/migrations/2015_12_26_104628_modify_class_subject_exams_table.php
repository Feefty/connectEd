<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyClassSubjectExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_subject_exams', function(Blueprint $t)
        {
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
        Schema::table('class_subject_exams', function(Blueprint $t)
        {
            $t->dropColumn('start', 'end');
        });
    }
}
