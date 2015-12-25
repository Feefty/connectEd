<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropExamQuestionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('exam_question_types');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('exam_question_types', function (Blueprint $t)
        {
            $t->increments('id');
            $t->string('name')->unique();
            $t->longText('description');
            $t->timestamps();
        });
    }
}
