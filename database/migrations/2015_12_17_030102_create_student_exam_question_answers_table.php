<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentExamQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exam_question_answers', function(Blueprint $t)
        {
            $t->increments('id');
            $t->longText('answer');
            $t->timestamp('created_at');
            $t->integer('user_id');
            $t->integer('exam_question_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('student_exam_question_answers');
    }
}
