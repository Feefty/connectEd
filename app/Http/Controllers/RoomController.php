<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostEnrollClassFormRequest;
use App\Http\Controllers\Controller;
use App\ClassSection;
use App\ClassStudent;
use App\ClassSectionCode;
use Auth;

class RoomController extends Controller
{
    public function getIndex()
    {
    	$section_id = Auth::user()->class_student->class_section_id;
        $section = null;

    	if ($section_id)
    	{
    		$section = ClassSection::with('teacher.profile')->findOrFail($section_id);
    	}

    	return view('room.index', compact('section'));
    }

    public function postEnroll(PostEnrollClassFormRequest $request)
    {
        $msg = [];

        try
        {
            $user = $request->user();
            $code = $request->class_code;

            if ( ! ClassSectionCode::leftJoin('class_sections', 'class_sections.id', '=', 'class_section_codes.class_section_id')
                                ->leftJoin('school_members', 'school_members.school_id', '=', 'class_sections.school_id')
                                ->where('class_section_codes.code', $code)
                                ->where('class_section_codes.status', 0)
                                ->where('school_members.user_id', $user->id)
                                ->exists())
            {
                throw new \Exception(trans('room.not_member'));
            }

            $class_section_code = ClassSectionCode::where('code', $code);
            // change the code status to active
            $class_section_code->update(['status' => 1]);

            $class_section_code = $class_section_code->first();

            ClassStudent::create([
                'student_id'            => $user->id,
                'class_section_id'      => $class_section_code->class_section_id,
                'class_section_code_id' => $class_section_code->id,
            ]);

            $msg = trans('room.enroll.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
