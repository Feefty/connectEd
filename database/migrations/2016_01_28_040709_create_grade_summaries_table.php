<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_summaries', function (Blueprint $t) {
            $t->increments('id');
            $t->integer('quarter');
            $t->double('grade');
            $t->string('remarks');
            $t->integer('school_year');
            $t->integer('class_subject_id');
            $t->integer('student_id');
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
        Schema::drop('grade_summaries');
    }
}
