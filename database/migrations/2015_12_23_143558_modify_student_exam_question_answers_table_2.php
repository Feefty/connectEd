<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyStudentExamQuestionAnswersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_exam_question_answers', function (Blueprint $t)
        {
            $t->integer('time_answered');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_exam_question_answers', function (Blueprint $t)
        {
            $t->dropColumn('time_answered');
        });
    }
}
