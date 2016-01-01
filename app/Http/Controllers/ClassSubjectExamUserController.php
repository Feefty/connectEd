<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddClassSubjectExamUserFormRequest;
use App\Http\Controllers\Controller;
use App\ClassSubjectExamUser;

class ClassSubjectExamUserController extends Controller
{
    public function getApi(Request $request)
    {
        $class_subject_exam_user = ClassSubjectExamUser::with('user.profile', 'class_subject_exam')->orderBy('created_at', 'desc');

        if ($request->has('class_subject_exam_id'))
        {
            $class_subject_exam_user = $class_subject_exam_user->where('class_subject_exam_id', (int) $request->get('class_subject_exam_id'));
        }

        return $class_subject_exam_user->get();
    }

    public function postAdd(PostAddClassSubjectExamUserFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = [];
            foreach ($request->users as $user)
            {
                $class_subject_exam_user = ClassSubjectExamUser::where('user_id', $user)
                                        ->where('class_subject_exam_id', (int) $request->class_subject_exam_id);
                
                if ($class_subject_exam_user->exists())
                {
                    throw new \Exception(trans('class_subject_exam_user.already_exists'));
                    break;
                }

                $data[] = [
                    'user_id' => $user,
                    'class_subject_exam_id' => (int) $request->class_subject_exam_id,
                    'created_at' => new \DateTime
                ];
            }

            ClassSubjectExamUser::insert($data);
            
            $msg = trans('class_subject_exam_user.add.success');
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
            ClassSubjectExamUser::findOrFail($id)->delete();
            
            $msg = trans('class_subject_exam_user.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
