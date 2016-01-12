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
use Gate;

class ExamController extends Controller
{
    public function getApi(Request $request)
    {
        if (Gate::denies('read-exam'))
        {
            return abort(401);
        }

        $exam = Exam::with('subject', 'exam_type', 'class_subject_exam.assessment');

        switch (strtolower(auth()->user()->group->name))
        {
            case 'student':
                $exam = $exam->whereHas('class_subject_exam.class_subject_exam_user', function($query) {
                    $query->where('user_id', auth()->user()->id);
                })->whereHas('class_subject_exam.assessment', function($query) {
                    $query->where('student_id', auth()->user()->id);
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
    	$exam_types = ExamType::orderBy('name', 'asc')->get();
    	$subjects = Subject::orderby('name', 'asc')->get();

    	return view('exam.index', compact('school_id', 'exam_types', 'subjects'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-exam'))
        {
            return abort(401);
        }

        $exam = Exam::findOrFail($id);
        $exam_types = ExamType::orderBy('name', 'asc')->get();
        $subjects = Subject::orderby('name', 'asc')->get();

        return view('exam.edit', compact('exam', 'exam_types', 'subjects'));
    }

    public function getView($id)
    {
        if (Gate::denies('read-exam'))
        {
            return abort(401);
        }

    	$exam = Exam::with('subject', 'exam_type')->findOrFail($id);
    	return view('exam.view', compact('exam'));
    }

    public function postEdit(PostEditExamFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title');
            $data['subject_id'] = $request->subject;
            $data['exam_type_id'] = $request->exam_type;

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

            $data = $request->only('title');
            $data['exam_type_id'] = (int) $request->exam_type;
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
