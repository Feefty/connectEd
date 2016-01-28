<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyClassSubjectExamsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_subject_exams', function (Blueprint $t) {
            $t->dropColumn('status');
            $t->integer('quarter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_subject_exams', function (Blueprint $t) {
            $t->boolean('status');
            $t->dropColumn('quarter');
        });
    }
}
