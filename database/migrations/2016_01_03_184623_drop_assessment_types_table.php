<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAssessmentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('assessment_types');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::create('assessment_types', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('name');
            $t->longText('description');
            $t->boolean('status');
            $t->timestamps();
        });
    }
}
