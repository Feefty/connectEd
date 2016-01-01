<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Profile;

class ProfileController extends Controller
{
    public function getIndex(Request $request)
    {
        $profile = auth()->user()->profile;
    	return view('profile.index', compact('profile'));
    }

    public function getUser($id)
    {
        $profile = Profile::where('user_id', $id)->first();
        return view('profile.user', compact('profile'));
    }
}
