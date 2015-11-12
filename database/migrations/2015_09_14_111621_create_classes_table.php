<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_rooms', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('teacher_id');
            $t->integer('subject_id');
            $t->integer('school_id');
            $t->integer('level');
            $t->integer('year');
            $t->boolean('status');
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
        Schema::drop('class_rooms');
    }
}
