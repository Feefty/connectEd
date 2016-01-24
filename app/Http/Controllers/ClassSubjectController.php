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
use App\Profile;
use App\AssessmentCategory;
use Gate;

class ClassSubjectController extends Controller
{
	public function getApi(Request $request)
	{
        if (Gate::denies('read-class-subject'))
        {
            abort(401);
        }

        $class_subject = ClassSubject::with('teacher.profile', 'subject', 'class_section');

        if ($request->has('class_section_id'))
        {
            $class_subject = $class_subject->where('class_section_id', (int) $request->class_section_id);
        }

        if ($request->has('teacher_id') && strtolower(auth()->user()->group->name) == 'teacher')
        {
            $class_subject = $class_subject->where('teacher_id', (int) $request->teacher_id);
        }

        return $class_subject->orderBy('created_at', 'desc')->get();
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
                        })->whereHas('school_member', function($query) use($class_section) {
                            $query->where('school_id', $class_section->school_id);
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

        if (strtolower(auth()->user()->group->name) == 'teacher')
        {
            if ( ! ClassSubject::where('teacher_id', auth()->user()->id)->where('id', (int) $id)->exists())
            {
                return abort(401);
            }
        }

        $class_subject = ClassSubject::with('class_section', 'teacher.profile', 'subject.exam.assessment_category')
                                ->findOrFail((int) $id);
        $lessons = Lesson::with('user.profile')
                        ->whereHas('school', function($query) use($class_subject) {
                            $query->where('id', $class_subject->class_section->id);
                        })
                        ->orderBy('title')
                        ->get();
        $users = Profile::whereHas('user.class_student.class_section', function($query) use($class_subject) {
                        $query->where('id', $class_subject->id);
                    })
                    ->orderBy('last_name')
                    ->orderBy('first_name')
                    ->get();

        $assessment_categories = AssessmentCategory::orderBy('name')->get();
		return view('class.subject.view', compact('class_subject', 'lessons', 'users', 'assessment_categories'));
	}

	public function getDelete($id)
	{
        $msg = [];

        try
        {
            if (Gate::denies('delete-class-subject'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
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
