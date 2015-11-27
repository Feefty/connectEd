<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddSubjectScheduleFormRequest;
use App\Http\Requests\PostEditSubjectScheduleFormRequest;
use App\Http\Controllers\Controller;
use App\SubjectSchedule;

class SubjectScheduleController extends Controller
{
	public function getAPI($id)
	{
		return SubjectSchedule::select('*', \DB::raw('CONCAT(subject_schedules.time_start, " - ", subject_schedules.time_end) as time'))
									->where('class_subject_id', (int) $id)
									->get();
	}

    public function getEdit($id)
    {
        $subject_schedule = SubjectSchedule::findOrFail((int) $id);

        return view('class.subject.schedule.edit', compact('subject_schedule'));
    }

    public function postEdit(PostEditSubjectScheduleFormRequest $request)
    {
        $msg = [];

        try
        {
            $id = (int) $request->id;

            $subject_schedule = SubjectSchedule::where('id', $id);

            if ( ! $subject_schedule->exists())
            {
                throw new \Exception('subject_schedule.not_found');
            }

            $data = $request->only('day', 'time_start', 'time_end');

            SubjectSchedule::where('id', $id)->update($data);

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
            if (SubjectSchedule::where('id', $id)->exists())
            {
                SubjectSchedule::where('id', $id)->delete();
            }
            else
            {
                throw new \Exception(trans('subject_schedule.not_found'));
            }
            
            $msg = trans('subject_schedule.delete.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
