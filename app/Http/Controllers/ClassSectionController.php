<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostAddClassSectionFormRequest;
use App\Http\Requests\PostAddClassSubjectScheduleFormRequest;
use App\Http\Requests\PostEditClassSectionFormRequest;
use App\Http\Controllers\Controller;
use Gate;
use App\Subject;
use App\SchoolMember;
use App\ClassSection;
use App\SubjectSchedule;
use App\ClassSubject;
use App\School;
use App\User;
use Auth;

class ClassSectionController extends Controller
{   
    public function getAPI($school_id, $section_id = null)
    {
        if (Gate::denies('read-class-section'))
        {
            abort(401);
        }

        return ClassSection::with('teacher.profile')->where('school_id', $school_id)->get();
    }

    public function getIndex()
    {
        if (Gate::denies('read-class-section'))
        {
            abort(401);
        }

        $school_id = SchoolMember::where('user_id', Auth::user()->id)->pluck('school_id');

        if ( ! $school_id)
        {
            return abort(404);
        }

        $teachers = User::with('profile')->whereHas('group', function($query) {
            $query->where('level', config('school.teacher_level'));
        })->whereHas('school_member', function($query) use($school_id) {
            $query->where('school_id', $school_id);
        })->get();

        return view('class.section.index', compact('teachers', 'school_id'));
    }

    public function postAdd(PostAddClassSectionFormRequest $request)
    {
        $msg = [];

        try
        {
            $school_id = Auth::user()->school_member->school_id;

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
        if (Gate::denies('read-class-section'))
        {
            abort(401);
        }

        /*if (auth()->user()->group->name == 'Teacher')
        {
            if ( ! ClassSection::where('adviser_id', auth()->user()->id)->where('id', (int) $section_id)->exists())
            {
                return abort(401);
            }
        }*/

        $section = ClassSection::with('school', 'teacher.profile')->findOrFail($section_id);
        $subjects = Subject::orderBy('name')->get();
        $teachers = User::with('profile')
                        ->whereHas('group', function($query) {
                            $query->where('level', config('school.teacher_level'));
                        })->whereHas('school_member', function($query) use($section) {
                            $query->where('school_id', $section->school_id);
                        })->get();

        return view('class.section.view', compact('section', 'subjects', 'teachers'));
    }

    public function getEdit($id)
    {
        if (Gate::denies('update-class-section'))
        {
            abort(401);
        }

        $class_section = ClassSection::findOrFail($id);

        $teachers = User::with('profile')
                        ->whereHas('group', function($query) {
                            $query->where('level', config('school.teacher_level'));
                        })->whereHas('school_member', function($query) use($class_section) {
                            $query->where('school_id', $class_section->school_id);
                        })->get();

        return view('class.section.edit', compact('class_section', 'teachers'));
    }

    public function postEdit(PostEditClassSectionFormRequest $request)
    {
        $msg = [];

        try
        {
            $id = (int) $request->id;

            $data = $request->only('name', 'level', 'year', 'status');
            $data['adviser_id'] = (int) $request->adviser;
            $data['updated_at'] = new \DateTime;

            ClassSection::findOrFail($id)->update($data);
            
            $msg = trans('class_section.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
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

                $class_subject = ClassSubject::with('class_section.school')->findOrFail($class_subject->id);

                $info = $data[$i];

                // To check if the schedule is conflict to other existing schedule
                $school = School::whereHas('class_section.subject.subject_schedule', function($query) use($info) {
                    $query->where('day', $info['day'])
                        ->where('time_start', '>=', $info['time_start'])
                        ->where('time_end', '<=', $info['time_end']);
                })->whereHas('class_section.subject', function($query) use($class_subject) {
                    $query->where('room', $class_subject->room);
                })->whereHas('class_section.school', function($query) use($class_subject) {
                    $query->where('id', $class_subject->class_section->school->id);
                });

                if ($school->exists())
                {
                    throw new \Exception(trans('subject_schedule.conflict.error'));
                }
            }

            SubjectSchedule::insert($data);

            $msg = trans('class_section.subject.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
