<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_calendar', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('title');
            $t->date('date');
            $t->longText('description')->nullable();
            $t->integer('updated_by');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('course_calendar');
    }
}
