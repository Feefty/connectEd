<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddSchoolMemberFormRequest;
use App\Http\Controllers\Controller;
use App\SchoolMember;
use App\School;
use App\User;
use Auth;
use Gate;

class SchoolMemberController extends Controller
{
	public function getAPI($school_id)
	{
		$school_members = SchoolMember::select('school_members.*', 'users.username', 'groups.name as group')
										->leftJoin('users', 'users.id', '=', 'school_members.user_id')
										->leftJoin('groups', 'groups.id', '=', 'users.group_id')
										->where('school_id', $school_id)->get();

		if ($school_members->count())
		{
			return $school_members;
		}
		else
		{
			return abort(404);
		}
	}

    public function getIndex()
    {
    	$user = Auth::user();
    	$school = School::leftJoin('school_members', 'school_members.school_id', '=', 'schools.id')
    					->where('school_members.user_id', $user->id)->first();

    	if ( ! $school)
    	{
    		return abort(404);
    	}

        return view('school.member.index', compact('school'));
    }

    public function postAdd(PostAddSchoolMemberFormRequest $request)
    {
        $msg = [];

        try
        {
        	$user = User::select('users.*', 'groups.level')
        				->leftJoin('groups', 'groups.id', '=', 'users.group_id')
        				->where('username', $request->username)
        				->first();
        	$school_member = SchoolMember::where('user_id', $user->id);

        	if ($school_member->exists())
        	{
        		throw new \Exception(trans('school.exists.member'));
        	}

        	if ($user->level < config('school.member_min_group_level'))
        	{
        		throw new \Exception(trans('school.low_level.member'));
        	}

        	$data = [
        		'school_id'		=> $request->school_id,
        		'user_id'		=> $user->id,
        		'created_at' 	=> new \DateTime
        	];

            SchoolMember::insert($data);

            $msg = trans('school.add.member');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            if (Gate::denies('delete-member-school'))
            {
                return abort(401);
            }
            
            if (SchoolMember::where('id', $id)->exists())
            {
                SchoolMember::where('id', $id)->delete();
            }
            else
            {
                throw new \Exception(trans('school.member_not_found'));
            }
            
            $msg = trans('school.delete.success.member');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
