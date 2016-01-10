<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddAttendanceFormRequest;
use App\Http\Controllers\Controller;
use App\Attendance;
use App\Notification;
use App\ClassSubject;
use Gate;

class AttendanceController extends Controller
{
    public function getApi(Request $request)
    {
    	if (Gate::denies('read-attendance'))
    	{
    		return abort(401);
    	}

    	$attendance = Attendance::with('student.profile', 'class_subject');

    	if ($request->has('class_subject_id'))
    	{
    		$attendance = $attendance->where('class_subject_id', (int) $request->class_subject_id);
    	}

        if (strtolower(auth()->user()->group->name) == 'student')
        {
            $attendance = $attendance->where('student_id', auth()->user()->id);
        }

    	return $attendance->orderBy('created_at', 'desc')->get();
    }

    public function postAdd(PostAddAttendanceFormRequest $request)
    {
        $msg = [];

        try
        {
            if (Gate::denies('create-attendance'))
            {
                throw new \Exception(trans('error.unauthorized.action'));
            }
            
            $attendance = Attendance::where('student_id', (int) $request->user_id)
                                    ->where('class_subject_id', (int) $request->class_subject_id)
                                    ->where('date', $request->date);
            
            if ($attendance->exists())
            {
                $attendance->update(['status' => (int) $request->status]);
            }
            else
            {
                $data = $request->only('class_subject_id', 'status', 'date');
                $data['student_id'] = (int) $request->user_id;
                Attendance::create($data);
            }

            $class_subject = ClassSubject::with('subject')->findOrFail($data['class_subject_id']);

            Notification::create([
                'target_id'     => $data['student_id'],
                'subject'       => 'Attendance',
                'content'       => 'Your attendance in '. $class_subject->subject->name .' is '. config('attendance.status')[$data['status']] .' on '. $data['date'] .'.',
                'created_at'    => new \DateTime,
                'url'           => action('ClassSubjectController@getView', $data['class_subject_id']),
                'read'          => 0
            ]);

            $msg = trans('attendance.add.success');
        }
        catch (\Exception $e)
        {
            return response()->json(['msg' => $e->getMessage()], 422);
        }

        return response()->json(compact('msg'));
    }
}
