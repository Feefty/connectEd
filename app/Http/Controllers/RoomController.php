<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ClassSection;
use App\ClassStudent;
use App\ClassMember;
use Auth;

class RoomController extends Controller
{
    public function getIndex()
    {
    	$user_id = Auth::user()->id;
    	$section_id = ClassStudent::where('student_id', $user_id)->pluck('class_section_id');

    	if ($section_id)
    	{
    		$section = ClassSection::select('class_sections.*', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as adviser'))
    								->leftJoin('profiles', 'profiles.user_id', '=', 'class_sections.adviser_id')
    								->where('class_sections.id', $section_id)
    								->first();
    	}
    	else
    	{
    		return abort(404);
    	}


    	return view('room.index', compact('section'));
    }
}
