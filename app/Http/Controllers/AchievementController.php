<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StudentAchievement;
use App\Achievement;
use Auth;
use Gate;

class AchievementController extends Controller
{
	public function getAPI($student_id = null)
	{
    	if (is_null($student_id))
    	{
    		$student_id = Auth::user()->user_id;
    	}

    	return StudentAchievement::where('student_id', $student_id)->get();
	}

    public function getIndex()
    {
    	$achievements = Achievement::orderBy('title')->get();

    	if (Gate::denies('student-achievement-create', ['strict']))
    	{
    		return view('achievement.index');
    	}
    	else
    	{
    		return view('achievement.create', compact('achievements'));
    	}
    }
}
