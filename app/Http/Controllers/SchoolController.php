<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostEditSchoolFormRequest;
use App\Http\Controllers\Controller;
use App\School;
use App\SchoolMember;

class SchoolController extends Controller
{
    public function getIndex($id)
    {
    	$school = School::with('member', 'class_section')->findOrFail((int) $id);
    	return view('school.index', compact('school'));
    }

    public function getEdit($id)
    {
    	$school = School::findOrFail((int) $id);

    	if ( ! SchoolMember::where(['user_id' => auth()->user()->id, 'school_id' => $id])->exists() ||
    		strtolower(auth()->user()->group->name) != 'school admin')
    	{
    		return abort(401);
    	}

    	return view('school.edit', compact('school'));
    }

    public function postEdit(PostEditSchoolFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'address', 'description', 'website', 'contact_no', 'mission', 'vision', 'motto', 'goal');
            School::findOrFail((int) $request->school_id)->update($data);
            
            $msg = trans('school.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
