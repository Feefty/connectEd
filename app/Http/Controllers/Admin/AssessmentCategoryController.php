<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddAssessmentCategoryFormRequest;
use App\Http\Requests\PostEditAssessmentCategoryFormRequest;
use App\Http\Controllers\Controller;
use App\AssessmentCategory;

class AssessmentCategoryController extends Controller
{
	public function getApi()
	{
		return AssessmentCategory::orderBy('created_at', 'desc')->get();
	}

    public function getIndex()
    {
    	return view('admin.assessment.category.index');
    }

    public function getEdit($id)
    {
    	$assessment_category = AssessmentCategory::findOrFail((int) $id);
    	return view('admin.assessment.category.edit', compact('assessment_category'));
    }

    public function postEdit(PostEditAssessmentCategoryFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('name', 'description');

            AssessmentCategory::findOrFail((int) $request->assessment_category_id)->update($data);

            $msg = trans('assessment_category.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddAssessmentCategoryFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('name', 'description');

            AssessmentCategory::create($data);

            $msg = trans('assessment_category.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
