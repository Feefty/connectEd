<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddSubjectScheduleFormRequest;
use App\Http\Requests\PostEditSubjectScheduleFormRequest;
use App\Http\Controllers\Controller;
use App\SubjectSchedule;
use Gate;

class SubjectScheduleController extends Controller
{
	public function getAPI($id)
	{
        if (Gate::denies('read-subject-schedule'))
        {
            return abort(401);
        }

		return SubjectSchedule::select('*', \DB::raw('CONCAT(subject_schedules.time_start, " - ", subject_schedules.time_end) as time'))
									->where('class_subject_id', (int) $id)
									->get();
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
