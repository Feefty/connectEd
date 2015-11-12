<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function(Blueprint $t)
        {
            $t->increments('id');
            $t->double('score');
            $t->integer('student_id');
            $t->integer('assessed_by');
            $t->string('source')->nullable();
            $t->integer('type_id');
            $t->integer('subject_id');
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
        Schema::drop('assessments');
    }
}
