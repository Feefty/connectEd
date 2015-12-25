<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddExamTypeFormRequest;
use App\Http\Controllers\Controller;
use App\ExamType;

class ExamTypeController extends Controller
{
    public function getDelete($id)
    {
        $msg = [];
        
        try
        {
            $group = ExamType::findOrFail($id)->delete();
            
            $msg = trans('exam_type.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getApi(Request $request)
    {
    	return ExamType::orderBy('id', 'desc')->get();
    }

    public function postAdd(PostAddExamTypeFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('name', 'description');
            ExamType::create($data);

            $msg = trans('exam_type.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
