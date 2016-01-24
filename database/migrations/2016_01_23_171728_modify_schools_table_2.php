<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifySchoolsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $t) {
            $t->dropColumn('code');
            $t->string('logo')->nullable();
            $t->string('contact_no')->nullable();
            $t->string('website')->nullable();
            $t->longText('motto');
            $t->longText('mission');
            $t->longText('vision');
            $t->longText('goal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $t) {
            $t->string('code');
            $t->dropColumn('logo', 'contact_no', 'website', 'mission', 'vision', 'motto', 'goal');
        });
    }
}
