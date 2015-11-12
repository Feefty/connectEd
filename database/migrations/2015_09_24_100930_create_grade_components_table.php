<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_components', function(Blueprint $t)
        {
            $t->increments('id');
            $t->integer('subject_id');
            $t->integer('school_id');
            $t->longText('description')->nullable();
            $t->double('percentage');
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
        Schema::drop('grade_components');
    }
}
