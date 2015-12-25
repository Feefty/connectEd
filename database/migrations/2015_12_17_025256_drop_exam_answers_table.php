<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('exam_answers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('exam_answers', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('exam_question_id');
            $t->longText('answer');
            $t->timestamps();
        });
    }
}
