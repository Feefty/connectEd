<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostAddCourseCalendarFormRequest;
use App\Http\Controllers\Controller;
use App\CourseCalendar;

class CourseCalendarController extends Controller
{
    public function getData(Request $request)
    {
        $data = [];

        $course_calendar = new CourseCalendar;

        if ($request->has('school_id'))
        {
            $course_calendar = $course_calendar->where('school_id', (int) $request->school_id);
        }

        if ($request->has('class_section_id'))
        {
            $course_calendar = $course_calendar->where('class_section_id', (int) $request->class_section_id);
        }

        foreach ($course_calendar->get() as $row)
        {
            if ($row->date_to != '0000-00-00' && ! is_null($row->date_to))
            {
                $data[] = [
                    'title'     => $row->title,
                    'start'     => $row->date_from,
                    'end'       => $row->date_to
                ];
            }
            else
            {
                $data[] = [
                    'title'     => $row->title,
                    'start'     => $row->date_from
                ];
            }
        }

        return $data;
    }

    public function getIndex()
    {
        return view('course_calendar.index');
    }

    public function postAdd(PostAddCourseCalendarFormRequest $request)
    {
        $msg = [];

        try
        {
            $data = $request->only('title', 'description', 'date_from', 'date_to', 'class_section_id', 'school_id');
            $data['updated_by'] = auth()->user()->id;

            CourseCalendar::create($data);

            $msg = trans('course_calendar.add.success');
        }
        catch (\Exception $e)
        {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->back()->with(compact('msg'));
    }
}
