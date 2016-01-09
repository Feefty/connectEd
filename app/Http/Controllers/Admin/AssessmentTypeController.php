<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddAssessmentTypeFormRequest;
use App\Http\Requests\PostEditAssessmentTypeFormRequest;
use App\Http\Controllers\Controller;
use App\AssessmentType;

class AssessmentTypeController extends Controller
{
    public function getApi(Request $request)
    {
    	return AssessmentType::orderBy('created_at', 'desc')->get();
    }

    public function getEdit($id)
    {
    	$assessment_type = AssessmentType::findOrFail($id);

    	return view('admin.assessment.type.edit', compact('assessment_type'));
    }

    public function postEdit(PostEditAssessmentTypeFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('name', 'description', 'status');

        	AssessmentType::findOrFail((int) $request->assessment_type_id)->update($data);
            $msg = trans('assessment_type.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddAssessmentTypeFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('name', 'description', 'status');

        	AssessmentType::create($data);
            $msg = trans('assessment_type.add.success');
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
        	AssessmentType::findOrFail((int) $id);
            $msg = trans('assessment_type.add.delete');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
