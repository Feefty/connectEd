<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyExamQuestionsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_questions', function (Blueprint $t)
        {
            $t->dropColumn('exam_question_type_id');
            $t->integer('time_limit')->default(0);
            $t->string('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_questions', function (Blueprint $t)
        {
            $t->integer('exam_question_type_id');
            $t->dropColumn('time_limit', 'category');    
        });
    }
}
