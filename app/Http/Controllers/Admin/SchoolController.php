<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddSchoolFormRequest;
use App\Http\Requests\PostEditSchoolFormRequest;
use App\Http\Requests\PostAddMemberSchoolPostRequest;
use App\Http\Controllers\Controller;
use App\School;
use App\SchoolMember;
use App\User;
use Gate;

class SchoolController extends Controller
{
	public function getAPI()
	{
        if (Gate::denies('api-school'))
        {
            return abort(401);
        }

		return School::select('schools.*', \DB::raw('COUNT("school_members.id") AS members'))
					->leftjoin('school_members', 'school_members.school_id', '=', 'schools.id')
					->groupBy('schools.id')
					->get();
	}

    public function getIndex()
    {
        if (Gate::denies('read-school'))
        {
            return abort(401);
        }

    	return view('admin.school.index');
    }

    public function postAdd(PostAddSchoolFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'description', 'address', 'motto', 'vision', 'mission', 'goal', 'contact_no', 'website');
            $data['created_at'] = new \DateTime;
            School::create($data);

            $msg = trans('school.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-school'))
        {
            return abort(401);
        }

    	$school = School::findOrFail($id);
    	return view('admin.school.view', compact('school'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-school'))
        {
            return abort(401);
        }

    	$school = School::findOrFail($id);
    	return view('admin.school.edit', compact('school'));
    }

    public function postEdit(PostEditSchoolFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'description', 'address', 'motto', 'vision', 'mission', 'goal', 'contact_no', 'website');
            $data['updated_at'] = new \DateTime;
            $id = (int) $request->school_id;
            School::where('id', $id)->update($data);

            $msg = trans('school.edit.success');
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
            if (Gate::denies('delete-school'))
            {
                return abort(401);
            }

        	if (School::where('id', $id)->exists())
        	{
        		School::where('id', $id)->delete();
        	}
        	else
        	{
        		throw new \Exception(trans('school.not_found'));
        	}

            $msg = trans('school.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAddMember(PostAddMemberSchoolPostRequest $request)
    {
        $msg = [];

        try
        {
            $user = User::where('username', $request->username)->first();
            $school_members = SchoolMember::where('school_id', (int) $request->school_id)
                                        ->where('user_id', (int) $user->id);

            if ($school_members->exists())
            {
                throw new \Exception(trans('school.member.exists'));
            }

            $data = [
                'user_id'   => $user->id,
                'school_id' => $request->school_id,
                'created_at'=> new \DateTime
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

    public function getMemberAPI($school_id)
    {
        $school_members = SchoolMember::where('school_id', $school_id);

        if ( ! $school_members->exists())
        {
            return abort(404);
        }

        return SchoolMember::select('school_members.id', 'school_members.user_id', 'school_members.created_at', 'school_members.updated_at', 'users.username')
                            ->where('school_members.school_id', $school_id)
                            ->join('users', 'users.id', '=', 'school_members.user_id')
                            ->get();
    }

    public function getDeleteMember($id)
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
