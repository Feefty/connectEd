<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddExamFormRequest;
use App\Http\Requests\PostEditExamFormRequest;
use App\Http\Controllers\Controller;
use App\SchoolMember;
use App\ExamType;
use App\Exam;
use App\Subject;
use App\User;
use App\AssessmentCategory;
use Gate;

class ExamController extends Controller
{
    public function getApi(Request $request)
    {
        if (Gate::denies('read-exam'))
        {
            return abort(401);
        }

        $exam = Exam::with('subject', 'assessment_category', 'exam_type');

        switch (strtolower(auth()->user()->group->name))
        {
            case 'student':
                $exam = $exam->whereHas('class_subject_exam.class_subject_exam_user', function($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                break;
            case 'school':
            case 'teacher':
                if ($request->has('school_id'))
                {
                    $exam = $exam->where('school_id', $request->school_id);
                }
                break;
        }

        return $exam->orderBy('created_at', 'desc')->get();
    }

    public function getIndex(Request $request)
    {
        if (Gate::denies('read-exam'))
        {
            return abort(401);
        }

    	$school_id = auth()->user()->school_member->school_id;
    	$subjects = Subject::orderby('name', 'asc')->get();
        $exam_types = ExamType::orderBy('name')->get();
        $assessment_categories = AssessmentCategory::orderBy('name')->get();

    	return view('exam.index', compact('school_id', 'subjects', 'assessment_categories', 'exam_types'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-exam'))
        {
            return abort(401);
        }

        $exam = Exam::with('exam_type')->findOrFail($id);
        $subjects = Subject::orderby('name', 'asc')->get();
        $exam_types = ExamType::orderBy('name')->get();
        $assessment_categories = AssessmentCategory::orderBy('name')->get();

        return view('exam.edit', compact('exam', 'subjects', 'assessment_categories', 'exam_types'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-exam'))
        {
            return abort(401);
        }

    	$exam = Exam::with('subject', 'assessment_category')->findOrFail($id);
    	return view('exam.view', compact('exam'));
    }

    public function postEdit(PostEditExamFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'assessment_category_id', 'exam_type_id');
            $data['subject_id'] = $request->subject;

            Exam::findOrFail($request->exam_id)->update($data);

            $msg = trans('exam.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddExamFormRequest $request)
    {
        $msg = [];

        try
        {
            $school_id = auth()->user()->school_member->school_id;

        	if (is_null($school_id))
        	{
        		throw new \Exception(trans('user.no_school'));
        	}

            $data = $request->only('title', 'assessment_category_id', 'exam_type_id');
            $data['subject_id'] = (int) $request->subject;
            $data['school_id'] = $school_id;
            $data['created_by'] = auth()->user()->id;

            $exam = Exam::create($data);

            $msg = trans('exam.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->action('ExamController@getView', $exam->id)->with(compact('msg'));
    }

    public function getDelete($id)
    {
        $msg = [];

        try
        {
            if (Gate::denies('delete-exam'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

            Exam::findOrFail($id)->delete();
            $exam_question = ExamQuestion::where('exam_id', $id)->delete();
            ExamQuestionAnswer::where('exam_question_id', $exam_question->id)->delete();

            $msg = trans('exam.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
