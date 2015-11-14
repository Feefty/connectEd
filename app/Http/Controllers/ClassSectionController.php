<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddClassSectionFormRequest;
use App\Http\Controllers\Controller;
use Gate;
use App\Subject;
use App\SchoolMember;
use App\ClassSection;
use App\ClassSchedule;
use Auth;

class ClassSectionController extends Controller
{   
    public function getAPI($school_id, $section_id = null)
    {
        return ClassSection::select('class_sections.*', 'users.username as adviser')
                                ->leftJoin('users', 'users.id', '=', 'class_sections.adviser_id')
                                ->where('class_sections.school_id', $school_id)
                                ->get();
    }

    public function getIndex()
    {
        $school_id = SchoolMember::where('user_id', Auth::user()->id)->pluck('school_id');

        if ( ! $school_id)
        {
            return abort(404);
        }

        $teachers = SchoolMember::select('users.username', 'users.id')
                                    ->leftJoin('users', 'users.id', '=', 'school_members.user_id')
                                    ->leftJoin('groups', 'groups.id', '=', 'users.group_id')
                                    ->where('school_members.school_id', $school_id)
                                    ->where('groups.level', config('school.teacher_level'))
                                    ->get();

        return view('class.section.index', compact('teachers', 'school_id'));
    }

    public function postAdd(PostAddClassSectionFormRequest $request)
    {
        $msg = [];

        try
        {
            $school_id = SchoolMember::where('user_id', Auth::user()->id)->pluck('school_id');

            if ( ! $school_id)
            {
                return abort(404);
            }

            $data = $request->only('name', 'level', 'year', 'status');
            $data['adviser_id'] = (int) $request->adviser;
            $data['created_at'] = new \DateTime;
            $data['school_id'] = $school_id;

            ClassSection::create($data);

            $msg = trans('class.add.section.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

    public function getView($section_id)
    {
        $section = ClassSection::select('class_sections.*', 'profiles.*', 'schools.name as school')
                                ->where('class_sections.id', $section_id)
                                ->leftJoin('profiles', 'profiles.user_id', '=', 'class_sections.adviser_id')
                                ->leftJoin('schools', 'schools.id', '=', 'class_sections.school_id');

        if ( ! $section->exists())
        {
            return abort(404);
        }

        $section = $section->first();
        
        return view('class.section.view', compact('section'));
    }

    public function getEdit($school_id)
    {
        $class_section = ClassSection::where('school_id', $school_id);

        if ( ! $class_section->exists())
        {
            return abort(404);
        }

        $class_section = $class_section->first();

        return view('class.section.edit', compact('class_section'));
    }
}
