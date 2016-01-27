<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddParentFormRequest;
use App\Http\Controllers\Controller;
use App\StudentParent;
use App\Profile;
use App\User;

class ParentController extends Controller
{
    public function getApi()
    {
        $students = User::with('profile', 'class_student.class_section.teacher.profile')
        ->whereHas('student_parent', function($query) {
            $query->where('parent_id', auth()->user()->id);
        })->get();

        return $students;
    }

    public function getIndex()
    {
        return view('parent.index');
    }

    public function postAdd(PostAddParentFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('parent_code');
            $profile = Profile::where('parent_code', $data['parent_code']);

            if ($profile->exists())
            {
                $student_id = $profile->pluck('user_id');
                StudentParent::create(['student_id' => $student_id, 'parent_id' => auth()->user()->id]);
            }

            $msg = trans('parent.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($msg);
        }

        return redirect()->back()->with(compact('msg'));
    }
}
