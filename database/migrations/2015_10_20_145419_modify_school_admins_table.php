<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySchoolAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('school_admins', 'school_members');

        Schema::table('school_members', function(Blueprint $t)
        {
            $t->integer('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('school_members', 'school_members');

        Schema::table('school_members', function(Blueprint $t)
        {
            $t->dropColumn('level');
        });
    }
}
