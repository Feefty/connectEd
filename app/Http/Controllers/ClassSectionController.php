<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddClassSectionFormRequest;
use App\Http\Requests\PostAddClassSubjectScheduleFormRequest;
use App\Http\Controllers\Controller;
use Gate;
use App\Subject;
use App\SchoolMember;
use App\ClassSection;
use App\SubjectSchedule;
use App\ClassSubject;
use Auth;

class ClassSectionController extends Controller
{   
    public function getAPI($school_id, $section_id = null)
    {
        return ClassSection::select('class_sections.*', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as full_name'), 'profiles.user_id')
                                ->leftJoin('profiles', 'profiles.user_id', '=', 'class_sections.adviser_id')
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

        $subjects = Subject::orderBy('name')->get();
        if ( ! $section->exists())
        {
            return abort(404);
        }

        $section = $section->first();
        $teachers = SchoolMember::select('profiles.*', 'users.username', 'users.id')
                                    ->leftJoin('users', 'users.id', '=', 'school_members.user_id')
                                    ->leftJoin('groups', 'groups.id', '=', 'users.group_id')
                                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
                                    ->where('school_members.school_id', $section->school_id)
                                    ->where('groups.level', config('school.teacher_level'))
                                    ->get();

        return view('class.section.view', compact('section', 'subjects', 'teachers'));
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

    public function postAddSubject(PostAddClassSubjectScheduleFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('room', 'class_section_id');
            $data['subject_id'] = (int) $request->subject;
            $data['teacher_id'] = (int) $request->teacher;
            $data['created_at'] = new \DateTime;

            $class_subject = ClassSubject::create($data);

            $data = [];

            for ($i = 0; $i < count($request->day); $i++)
            {
                $data[$i]['class_subject_id'] = (int) $class_subject->id;
                $data[$i]['day'] = $request->day[$i];
                $data[$i]['time_start'] = $request->time_start[$i];
                $data[$i]['time_end'] = $request->time_end[$i];
                $data[$i]['created_at'] = new \DateTime;
            }

            SubjectSchedule::insert($data);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
