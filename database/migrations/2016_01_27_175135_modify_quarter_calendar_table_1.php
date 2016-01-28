<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyQuarterCalendarTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quarter_calendar', function (Blueprint $t) {
            $t->integer('school_year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quarter_calendar', function (Blueprint $t) {
            $t->dropColumn('school_year');
        });
    }
}
