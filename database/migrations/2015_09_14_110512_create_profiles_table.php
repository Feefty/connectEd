<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function(Blueprint $t)
        {
            $t->integer('user_id');
            $t->string('first_name');
            $t->string('last_name');
            $t->string('middle_name')->nullable();
            $t->date('birthday');
            $t->longText('address')->nullable();
            $t->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('profiles');
    }
}
