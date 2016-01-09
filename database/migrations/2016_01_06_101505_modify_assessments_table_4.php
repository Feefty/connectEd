<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAssessmentsTable4 extends Migration
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
            $t->dropColumn('assessed_by', 'subject_id', 'school_id');
            $t->integer('class_student_id');
            $t->integer('class_subject_id');
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
            
            $t->integer('school_id');
            $t->integer('assessed_by');
            $t->integer('subject_id');
            $t->dropColumn('class_student_id', 'class_subject_id');
        });
    }
}
