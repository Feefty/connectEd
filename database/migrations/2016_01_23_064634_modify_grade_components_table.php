<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyGradeComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grade_components', function (Blueprint $t) {
            $t->dropColumn('school_id');
            $t->integer('assessment_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grade_components', function (Blueprint $t) {
            $t->dropColumn('assessment_category_id');
            $t->integer('school_id');
        });
    }
}
