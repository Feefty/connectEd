<?php

namespace App\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\SchoolMember;
use App\Group;

class AuthLoginEventHandler
{
    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Events  $event
     * @return void
     */
    public function handle(User $user, $remember)
    {
        /*$school_id = SchoolMember::where('user_id', $user->id)->orderBy('created_at', 'desc')->pluck('school_id');
        $user->setSchoolAttribute($school_id);

        $level = Group::findOrFail($user->group_id)->level;

        $user->setLevelAttribute($level);*/
    }
}
