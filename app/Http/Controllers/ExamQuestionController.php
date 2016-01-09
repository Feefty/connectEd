<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddExamQuestionFormRequest;
use App\Http\Requests\PostEditExamQuestionFormRequest;
use App\Http\Controllers\Controller;
use App\ExamQuestion;
use App\ExamQuestionAnswer;
use Gate;

class ExamQuestionController extends Controller
{
    public function getApi(Request $request)
    {
        if (Gate::denies('read-exam-question'))
        {
            return abort(401);
        }

        $exam_question = ExamQuestion::with('exam.author');

        if ($request->has('exam_id'))
        {
            $exam_question = $exam_question->where('exam_id', (int) $request->exam_id);
        }

        return $exam_question->orderBy('created_at', 'desc')->get();
    }

    public function getView($id)
    {
        if (Gate::denies('read-exam-question'))
        {
            return abort(401);
        }

        $exam_question = ExamQuestion::findOrFail($id);

        return view('exam.question.view', compact('exam_question'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-exam-question'))
        {
            return abort(401);
        }

        $exam_question = ExamQuestion::findOrFail($id);

        return view('exam.question.edit', compact('exam_question'));
    }

    public function postEdit(PostEditExamQuestionFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('question', 'time_limit');
            
            ExamQuestion::findOrFail((int) $request->exam_question_id)->update($data);

            $msg = trans('exam_question.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

	public function postAdd(PostAddExamQuestionFormRequest $request)
	{
        $msg = [];

        try
        {
            $data = $request->only('question', 'exam_id', 'category', 'time_limit');
            
            $exam_question = ExamQuestion::create($data);

            $data = [];
            for ($i = 0; $i < count($request->answer); $i++)
            {
            	if ( ! empty($request->answer[$i]))
            	{
            		$data[] = [
            			'answer'			=> $request->answer[$i],
            			'points'			=> (int) $request->points[$i],
            			'exam_question_id'	=> $exam_question->id,
            			'created_at'		=> new \DateTime 
            		];
            	}
            }

            ExamQuestionAnswer::insert($data);
            $msg = trans('exam_question.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
	}

    public function getDelete($id) 
    {
        $msg = [];

        try
        {
            if (Gate::denies('delete-exam-question'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

            ExamQuestion::findOrFail($id)->delete();
            ExamQuestionAnswer::where('exam_question_id', $id)->delete();

            $msg = trans('exam_question.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
