<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddClassSubjectLessonFormRequest;
use App\Http\Controllers\Controller;

use App\ClassSubjectLesson;

class ClassSubjectLessonController extends Controller
{
	public function getApi($class_subject)
	{
		return ClassSubjectLesson::select('class_subject_lessons.*', 'lessons.title')
								->leftJoin('lessons', 'lessons.id', '=', 'class_subject_lessons.lesson_id')
								->where('class_subject_lessons.class_subject_id', $class_subject)
								->get();
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
