<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySchoolMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_members', function(Blueprint $t)
        {
            $t->boolean('status')->default(false);
            $t->integer('school_code_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_members', function(Blueprint $t)
        {
            $t->dropColumn('status', 'school_code_id');
        });
    }
}
