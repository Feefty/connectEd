<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyClassSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('class_schedules', 'subject_schedules');

        Schema::table('subject_schedules', function(Blueprint $t)
        {
            $t->renameColumn('class_room_id', 'class_subject_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('subject_schedules', 'class_schedules');

        Schema::table('class_schedules', function(Blueprint $t)
        {
            $t->renameColumn('class_subject_id', 'class_room_id');
        });
    }
}
