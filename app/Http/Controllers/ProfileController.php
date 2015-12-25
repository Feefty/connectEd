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
    	$profile = Profile::select('*', \DB::raw('CONCAT(
                            profiles.first_name,
                            IF(profiles.middle_name <> "",CONCAT(" ",profiles.middle_name," ")," "),
                            profiles.last_name
                        ) as name'))

    						->where('user_id', $request->user()->id)->first();
        //$profile = auth()->user()->profile;
    	return view('profile.index', compact('profile'));
    }

    public function getUser($id)
    {
        $profile = Profile::select('*', \DB::raw('CONCAT(
                            profiles.first_name,
                            IF(profiles.middle_name <> "",CONCAT(" ",profiles.middle_name," ")," "),
                            profiles.last_name
                        ) as name'))
                            ->where('user_id', $id)->first();
        return view('profile.user', compact('profile'));
    }
}
