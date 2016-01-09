<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class ProfileController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = auth()->user();
    	return view('profile.index', compact('user'));
    }

    public function getUser($username)
    {
        $user = User::with('profile', 'school_member.school')->where('username', $username);

        if ($user->exists())
        {
            $user = $user->first();
        }
        else
        {
            return abort(404);
        }

        return view('profile.index', compact('user'));
    }
}
