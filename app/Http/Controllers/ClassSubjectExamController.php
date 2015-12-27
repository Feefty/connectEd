<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddClassSubjectExamFormRequest;
use App\Http\Controllers\Controller;

class ClassSubjectExamController extends Controller
{
    public function postAdd(PostAddClassSubjectExamFormRequest $request)
    {
        $msg = [];

        try
        {
        	$data = $request->only('class_subject_id');
        	$data['start'] = $request->start_date .' '. $request->start_time;
        	$data['end'] = $request->end_date .' '. $request->end_time;
        	$data['exam_id'] = $request->exam;
            
            $msg = trans('class_subject_exam.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));

    }
}
