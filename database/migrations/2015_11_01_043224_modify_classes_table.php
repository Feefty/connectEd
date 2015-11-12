<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('class_rooms', 'class_sections');

        Schema::table('class_sections', function(Blueprint $t)
        {
            $t->dropColumn('teacher_id');
            $t->integer('adviser_id');
            $t->string('name');
            $t->dropColumn('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('class_sections', 'class_rooms');

        Schema::table('class_rooms', function(Blueprint $t)
        {
            $t->integer('teacher_id');
            $t->integer('subject_id');
            $t->dropColumn('adviser_id', 'name');
        });
    }
}
