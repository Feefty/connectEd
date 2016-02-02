<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddStudentAchievementFormRequest;
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

	public function postAdd(PostAddStudentAchievementFormRequest $request)
	{
        $msg = [];

        try
        {
			$data = [];
            $student_id = $request->only('student_id');

			foreach ($request->achievement_ids as $achievement_id)
			{
				$data[] = [
					'student_id'	=> $student_id,
					'achievement_id'=> $achievement_id,
					'created_at' => new \DateTime
				];
			}

            StudentAchievement::insert($data);

            $msg = trans('student_achievement.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
	}
}
