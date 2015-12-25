<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddExamQuestionFormRequest;
use App\Http\Controllers\Controller;
use App\ExamQuestion;
use App\ExamQuestionAnswer;

class ExamQuestionController extends Controller
{
    public function getApi(Request $request)
    {
        $exam_question = new ExamQuestion;

        if ($request->has('exam_id'))
        {
            $exam_question = $exam_question->where('exam_id', (int) $request->exam_id);
        }

        return $exam_question->orderBy('created_at', 'desc')->get();
    }

    public function getView($id)
    {
        $exam_question = ExamQuestion::findOrFail($id);

        return view('exam.question.view', compact('exam_question'));
    }

    public function getEdit($id)
    {
        $exam_question = ExamQuestion::findOrFail($id);

        return view('exam.question.edit', compact('exam_question'));
    }

    public function postEdit()
    {
        
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
