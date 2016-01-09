<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddClassSubjectLessonFormRequest;
use App\Http\Controllers\Controller;

use App\ClassSubjectLesson;

class ClassSubjectLessonController extends Controller
{
	public function getApi(Request $request)
	{
		$class_subject_lesson = ClassSubjectLesson::with('lesson');

        if ($request->has('class_subject_id'))
        {
            $class_subject_lesson = $class_subject_lesson->where('class_subject_id', (int) $request->class_subject_id);
        }

        return $class_subject_lesson->get();
	}

    public function postAdd(PostAddClassSubjectLessonFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('class_subject_id');
        	$data['added_by'] = (int) $request->user()->id;
        	$data['lesson_id'] = (int) $request->lesson;
        	$data['created_at'] = new \DateTime;

            ClassSubjectLesson::create($data);
            
            $msg = trans('class_subject_lesson.add.success');
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
            ClassSubjectLesson::findOrFail($id)->delete();
            
            $msg = trans('class_subject_lesson.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
