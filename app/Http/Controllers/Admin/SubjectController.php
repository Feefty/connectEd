<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddSubjectFormRequest;
use App\Http\Requests\PostEditSubjectFormRequest;
use App\Http\Controllers\Controller;
use App\Subject;
use App\AssessmentCategory;
use App\GradeComponent;
use Gate;

class SubjectController extends Controller
{
	public function getAPI()
	{
        if (Gate::denies('api-subject'))
        {
            return abort(401);
        }

		return Subject::orderBy('name')->get();
	}

    public function getIndex()
    {
        if (Gate::denies('read-subject'))
        {
            return abort(401);
        }

    	return view('admin.subject.index');
    }

    public function postAdd(PostAddSubjectFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'code', 'description');
            Subject::create($data);

            $msg = trans('subject.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-subject'))
        {
            return abort(401);
        }

    	$subject = Subject::findOrFail($id);
    	return view('admin.subject.view', compact('subject'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-subject'))
        {
            return abort(401);
        }

    	$subject = Subject::findOrFail($id);
    	return view('admin.subject.edit', compact('subject'));
    }

    public function postEdit(PostEditSubjectFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'code', 'description');
            $id = (int) $request->subject_id;
            Subject::where('id', $id)->update($data);

            $msg = trans('subject.edit.success');
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
            if (Gate::denies('delete-subject'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

        	if ( ! Subject::findOrFail($id)->delete())
        	{
        		throw new \Exception(trans('subject.not_found'));
        	}

            $msg = trans('subject.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

	public function getGradeComponents($id)
	{
		$subject = Subject::findOrFail((int) $id);
		$assessment_categories = AssessmentCategory::orderBy('name')->get();
		return view('admin.subject.grade.component', compact('subject', 'assessment_categories'));
	}
}
