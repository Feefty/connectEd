<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostEditClassSubjectFormRequest;
use App\Http\Controllers\Controller;
use App\ClassSubject;
use App\SubjectSchedule;
use App\ClassSection;
use App\Subject;
use App\SchoolMember;
use App\Lesson;
use Gate;

class ClassSubjectController extends Controller
{
	public function getAPI($section_id)
	{
        if (Gate::denies('read-class-subject'))
        {
            abort(401);
        }

		return ClassSubject::select('class_subjects.*', 'users.username', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as teacher'), 'subjects.name as subject')
							->leftJoin('users', 'users.id', '=', 'class_subjects.teacher_id')
							->leftJoin('profiles', 'profiles.user_id', '=', 'class_subjects.teacher_id')
							->leftJoin('subjects', 'subjects.id', '=', 'class_subjects.subject_id')
							->where('class_subjects.class_section_id', (int) $section_id)
							->get();
	}

	public function getEdit($id)
	{
        if (Gate::denies('update-class-subject'))
        {
            abort(401);
        }

		$class_subject = ClassSubject::findOrFail($id);
		$class_section = ClassSection::findOrFail($class_subject->class_section_id);
        $subjects = Subject::orderBy('name')->get();
        $teachers = SchoolMember::select('profiles.*', 'users.username', 'users.id')
                                    ->leftJoin('users', 'users.id', '=', 'school_members.user_id')
                                    ->leftJoin('groups', 'groups.id', '=', 'users.group_id')
                                    ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
                                    ->where('school_members.school_id', $class_section->school_id)
                                    ->where('groups.level', config('school.teacher_level'))
                                    ->get();

		return view('class.subject.edit', compact('class_subject', 'teachers', 'subjects'));
	}

	public function postEdit(PostEditClassSubjectFormRequest $request)
	{
        $msg = [];

        try
        {
            $id = (int) $request->id;

            $class_subject = ClassSubject::findOrFail($id);

            $data = $request->only('room');
            $data['subject_id']	= $request->subject;
            $data['teacher_id']	= $request->teacher;
            $data['updated_at'] = new \DateTime;

            ClassSubject::findOrFail($id)->update($data);

            $msg = trans('class_subject.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
	}

	public function getView($id)
	{
        if (Gate::denies('read-class-subject'))
        {
            abort(401);
        }

		$class_subject = ClassSubject::select('class_sections.name as section', 'class_sections.level as section_level', 'class_subjects.*', 'users.username', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as teacher'))
							->leftJoin('users', 'users.id', '=', 'class_subjects.teacher_id')
							->leftJoin('profiles', 'profiles.user_id', '=', 'class_subjects.teacher_id')
							->leftJoin('class_sections', 'class_sections.id', '=', 'class_subjects.class_section_id')
							->findOrFail($id);

		$schedules = SubjectSchedule::select('*', \DB::raw('CONCAT(subject_schedules.time_start, " - ", subject_schedules.time_end) as time'))
									->where('class_subject_id', (int) $id)
									->get();

        $subject = Subject::findOrFail($class_subject->subject_id);
        $class_section = ClassSection::findOrFail($class_subject->class_section_id);
        $lessons = Lesson::select('lessons.*', \DB::raw('CONCAT(profiles.first_name, " ", profiles.last_name) as posted_by'))
                            ->where('school_id', $class_section->school_id)
                            ->leftJoin('profiles', 'profiles.user_id', '=', 'lessons.posted_by')
                            ->orderBy('title')
                            ->get();

		return view('class.subject.view', compact('class_subject', 'schedules', 'subject', 'lessons'));
	}

	public function getDelete($id)
	{
        $msg = [];

        try
        {
            if (Gate::denies('delete-class-subject'))
            {
                return abort(401);
            }

            ClassSubject::findOrFail($id)->delete();
            
            $msg = trans('class_subject.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
	}
}
