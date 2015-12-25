<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_files', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('name');
            $t->string('file_name')->unique();
            $t->timestamps();
            $t->integer('added_by');
            $t->integer('lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lesson_files');
    }
}
