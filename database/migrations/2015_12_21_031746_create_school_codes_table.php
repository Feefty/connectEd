<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_codes', function(Blueprint $t)
        {
            $t->increments('id');
            $t->string('code')->unique();
            $t->integer('school_id');
            $t->boolean('status')->default(0);
            $t->integer('group_id');
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
        Schema::drop('school_codes');
    }
}
