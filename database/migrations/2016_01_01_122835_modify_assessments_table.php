<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assessments', function (Blueprint $t)
        {
            $t->renameColumn('type_id', 'assessment_type_id');
            $t->integer('class_subject_exam_id')->nullable();
            $t->double('total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assessments', function (Blueprint $t) 
        {
            $t->renameColumn('assessment_type_id', 'type_id');
            $t->dropColumn('class_subject_exam_id', 'total');
        });
    }
}
