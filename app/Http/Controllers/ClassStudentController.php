<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddClassStudentFormRequest;
use App\Http\Controllers\Controller;
use App\ClassStudent;
use App\ClassSection;
use App\SchoolMember;
use App\User;
use Gate;

class ClassStudentController extends Controller
{
    public function getAPIBySection($section_id)
    {
        if (Gate::denies('read-class-student'))
        {
            abort(401);
        }

    	return ClassStudent::select('class_students.*', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as name, IF(gender=1, "Male", "Female") as gender'))
                            ->leftJoin('profiles', 'profiles.user_id', '=', 'class_students.student_id')
                            ->where('class_section_id', $section_id)
                            ->get();
    }

    public function postAdd(PostAddClassStudentFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('class_section_id');

            $user = User::where('username', $request->username);

            if ( ! $user->exists())
            {
                throw new \Exception(trans('user.not_found'));
            }

            $data['student_id'] = $user->pluck('id');
            $school_id = (int) ClassSection::firstOrFail((int) $data['class_section_id'])->school_id;

            if ( ! SchoolMember::where('user_id', $data['student_id'])->where('school_id', $school_id)->exists())
            {
                throw new \Exception(trans('class_student.not_member.error'));
            }

        	ClassStudent::create($data);

            $msg = trans('class_student.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
