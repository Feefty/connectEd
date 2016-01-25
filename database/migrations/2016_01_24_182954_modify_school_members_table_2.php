<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySchoolMembersTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('school_members', function (Blueprint $t) {
            $t->renameColumn('school_code_id', 'verification_code_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('school_members', function (Blueprint $t) {
            $t->renameColumn('verification_code_id', 'school_code_id');
        });
    }
}
