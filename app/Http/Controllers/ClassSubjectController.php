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
use App\Exam;
use App\User;
use Gate;

class ClassSubjectController extends Controller
{
	public function getAPI($section_id)
	{
        if (Gate::denies('read-class-subject'))
        {
            abort(401);
        }

        return ClassSubject::with('teacher.profile', 'subject')->orderBy('created_at', 'desc')->get();
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
        $teachers = User::with('profile')
                        ->whereHas('group', function($query) {
                            $query->where('level', config('school.teacher_level'));
                        })->whereHas('school_member', function($query) use($section) {
                            $query->where('school_id', $section->school_id);
                        })->get();

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

        $school_id = auth()->user()->school_member->school_id;

        $class_subject = ClassSubject::with('class_section', 'teacher.profile', 'subject.exam')
                                ->whereHas('subject.exam', function($query) use($school_id) {
                                    $query->where('school_id', $school_id);
                                })
                                ->findOrFail($id);
        $lessons = Lesson::with('user.profile')
                        ->whereHas('school', function($query) use($class_subject) {
                            $query->where('id', $class_subject->class_section->id);
                        })
                        ->orderBy('title')
                        ->get();
        $users = User::with('profile')
                    ->whereHas('class_student.class_section', function($query) use($class_subject) {
                        $query->where('id', $class_subject->id);
                    })
                    ->orderBy('username')
                    ->get();
		return view('class.subject.view', compact('class_subject', 'lessons', 'users'));
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
