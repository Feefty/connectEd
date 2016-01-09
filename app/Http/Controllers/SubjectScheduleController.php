<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddSubjectScheduleFormRequest;
use App\Http\Requests\PostEditSubjectScheduleFormRequest;
use App\Http\Controllers\Controller;
use App\SubjectSchedule;
use App\School;
use App\ClassSubject;
use Gate;

class SubjectScheduleController extends Controller
{
	public function getApi(Request $request)
	{
        if (Gate::denies('read-subject-schedule'))
        {
            return abort(401);
        }

        $subject_schedule = SubjectSchedule::select('*', \DB::raw('CONCAT(subject_schedules.time_start, " - ", subject_schedules.time_end) as time'));

        if ($request->has('class_subject_id'))
        {
            $subject_schedule = $subject_schedule->where('class_subject_id', (int) $request->class_subject_id);
        }

		return $subject_schedule->get();
	}

    public function getEdit($id)
    {
        if (Gate::denies('update-subject-schedule'))
        {
            return abort(401);
        }

        $subject_schedule = SubjectSchedule::findOrFail((int) $id);

        return view('class.subject.schedule.edit', compact('subject_schedule'));
    }

    public function postEdit(PostEditSubjectScheduleFormRequest $request)
    {
        $msg = [];

        try
        {
            $id = (int) $request->id;

            $data = $request->only('day', 'time_start', 'time_end');
            $class_subject_id = (int) $request->class_subject_id;

            $class_subject = ClassSubject::with('class_section.school')->findOrFail($class_subject_id);
            
            // To check if the schedule is conflict to other existing schedule
            $school = School::whereHas('class_section.subject.subject_schedule', function($query) use($data) {
                $query->where('day', $data['day'])
                    ->where('time_start', '>=', $data['time_start'])
                    ->where('time_end', '<=', $data['time_end']);
            })->whereHas('class_section.subject', function($query) use($class_subject) {
                $query->where('room', $class_subject->room);
            })->whereHas('class_section.school', function($query) use($class_subject) {
                $query->where('id', $class_subject->class_section->school->id);
            });

            SubjectSchedule::findOrFail($id)->update($data);

            $msg = trans('subject_schedule.edit.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }

	public function postAdd(PostAddSubjectScheduleFormRequest $request)
	{
        $msg = [];

        try
        {
        	$data = $request->only('day', 'time_start', 'time_end', 'class_subject_id');
            $room = $request->room;

            $class_subject = ClassSubject::with('class_section.school')->findOrFail($data['class_subject_id']);

            // To check if the schedule is conflict to other existing schedule
            $school = School::whereHas('class_section.subject.subject_schedule', function($query) use($data) {
                $query->where('day', $data['day'])
                    ->where('time_start', '>=', $data['time_start'])
                    ->where('time_end', '<=', $data['time_end']);
            })->whereHas('class_section.subject', function($query) use($class_subject) {
                $query->where('room', $class_subject->room);
            })->whereHas('class_section.school', function($query) use($class_subject) {
                $query->where('id', $class_subject->class_section->school->id);
            });

            if ($school->exists())
            {
                throw new \Exception(trans('subject_schedule.conflict.error'));
            }

        	$data['created_at'] = new \DateTime;

        	SubjectSchedule::create($data);

            $msg = trans('subject_schedule.add.success');
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
            if (Gate::denies('delete-subject-schedule'))
            {
                return abort(401);
            }

            SubjectSchedule::findOrFail('id', $id)->delete();
            
            $msg = trans('subject_schedule.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
