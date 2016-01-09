<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddSchoolMemberFormRequest;
use App\Http\Requests\PostGenerateSchoolMemberFormRequest;
use App\Http\Controllers\Controller;
use App\SchoolMember;
use App\SchoolCode;
use App\School;
use App\User;
use Auth;
use Gate;
use Hashids;

class SchoolMemberController extends Controller
{
	public function getApi(Request $request)
	{
        if (Gate::denies('read-school-member'))
        {
            return abort(401);
        }

        $school_member = SchoolMember::with('user.group', 'user.profile');

        if ($request->has('school_id'))
        {
            $school_member = $school_member->where('school_id', (int) $request->school_id);
        }

		return $school_member->get();
	}

    public function getIndex()
    {
        if (Gate::denies('read-school-member'))
        {
            return abort(401);
        }

    	$school = auth()->user()->school_member->school;

        return view('school.member.index', compact('school'));
    }

    public function postGenerate(PostGenerateSchoolMemberFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = [];
            $amount = (int) $request->amount;
            $school_id = (int) $request->school_id;
            $group_id = (int) $request->group;

            if (SchoolCode::where('school_id', $school_id)->count() >= config('school.max_code'))
            {
                throw new \Exception(trans('school.max_code_reahed'));
            }

            for ($i = 0; $i < $amount; $i++)
            {
                $count = SchoolCode::count();

                $hash = Hashids::encode($count);
                $data = [
                    'code'          => $hash,
                    'created_at'    => new \DateTime,
                    'school_id'     => $school_id,
                    'status'        => false,
                    'group_id'      => $group_id,
                ];

                SchoolCode::create($data);
            }

            $msg = trans('school_code.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddSchoolMemberFormRequest $request)
    {
        $msg = [];

        try
        {
        	$user = User::with('group')
                        ->where('username', $request->username)
        				->first();
        	$school_member = SchoolMember::where('user_id', $user->id);

        	if ($school_member->exists())
        	{
        		throw new \Exception(trans('school.exists.member'));
        	}

        	if ($user->group->level < config('school.member_min_group_level'))
        	{
        		throw new \Exception(trans('school.low_level.member'));
        	}

        	$data = [
        		'school_id'		=> $request->school_id,
        		'user_id'		=> $user->id,
        		'created_at' 	=> new \DateTime
        	];

            SchoolMember::create($data);

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
            if (Gate::denies('delete-school-member'))
            {
                return abort(401);
            }
            
            SchoolMember::findOrFail($id)->delete();
            
            $msg = trans('school.delete.success.member');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
