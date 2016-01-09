<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostEditExamQuestionAnswerEditFormRequest;
use App\Http\Requests\PostAddExamQuestionAnswerFormRequest;
use App\Http\Controllers\Controller;
use App\ExamQuestionAnswer;
use Gate;

class ExamQuestionAnswerController extends Controller
{
    public function getApi(Request $request)
    {
        if (Gate::denies('read-exam-question-answer'))
        {
            return abort(401);
        }

    	$exam_question_answer = new ExamQuestionAnswer;

    	if ($request->has('exam_question_id'))
    	{
    		$exam_question_answer = $exam_question_answer->where('exam_question_id', (int) $request->exam_question_id);
    	}

    	return $exam_question_answer->orderby('created_at', 'desc')->get();
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-exam-question-answer'))
        {
            return abort(401);
        }

    	$exam_question_answer = ExamQuestionAnswer::findOrFail($id);
    	return view('exam.question.answer.edit', compact('exam_question_answer'));
    }

    public function postEdit(PostEditExamQuestionAnswerEditFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('answer', 'points');
        	ExamQuestionAnswer::findOrFail($request->exam_question_answer_id)->update($data);

            $msg = trans('exam_question_answer.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function postAdd(PostAddExamQuestionAnswerFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = [];
            $exam_question_id = (int) $request->exam_question_id;

            for ($i = 0; $i < count($request->answer); $i++)
            {
                if ( ! empty($request->answer[$i]))
                {
                    $data[] = [
                        'answer'            => $request->answer[$i],
                        'points'            => (int) $request->points[$i],
                        'exam_question_id'  => $exam_question_id,
                        'created_at'        => new \DateTime
                    ];
                }
            }

            ExamQuestionAnswer::insert($data);
            $msg = trans('exam_question_answer.add.success');
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
            if (Gate::denies('delete-exam-question-answer'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }

            ExamQuestionAnswer::findOrFail($id)->delete();

            $msg = trans('exam_question_answer.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
