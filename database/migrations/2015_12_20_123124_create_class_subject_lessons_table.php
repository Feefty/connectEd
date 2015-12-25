<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassSubjectLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_subject_lessons', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('class_subject_id');
            $t->integer('lesson_id');
            $t->integer('added_by');
            $t->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('class_subject_lessons');
    }
}
