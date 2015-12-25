<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $t)
        {
            $t->renameColumn('user_id', 'target_id');
            $t->renameColumn('title', 'subject');
            $t->renameColumn('message', 'content');
            $t->string('url');
            $t->boolean('read')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $t)
        {
            $t->renameColumn('target_id', 'user_id');
            $t->renameColumn('subject', 'title');
            $t->renameColumn('content', 'message');
            $t->dropColumn('url', 'read');
        });
    }
}
