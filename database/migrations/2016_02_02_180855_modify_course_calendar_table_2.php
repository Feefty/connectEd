<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyCourseCalendarTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_calendar', function (Blueprint $t) {
            $t->dropColumn('date');
            $t->date('date_from');
            $t->date('date_to');
            $t->integer('school_id')->nullable();
            $t->dropColumn('class_section_id');
        });

        Schema::table('course_calendar', function (Blueprint $t) {
            $t->integer('class_section_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_calendar', function (Blueprint $t) {
            $t->dropColumn('date_from', 'date_to', 'school_id');
            $t->date('date');
            $t->integer('class_section_id');
        });
    }
}
